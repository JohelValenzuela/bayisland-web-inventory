<?php

namespace Controllers;

use Model\Cliente;
use Model\Cobro;
use Model\Producto;
use Model\Receta;
use Model\Venta;
use Model\VentaProductos; // Agrega el modelo de VentaProductos
use MVC\Router;

class CobrosController {

    public static function mostrar(Router $router) {
        $clientes = Cliente::all();
        $clienteSeleccionado = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cliente_id'])) {
            $clienteSeleccionado = Cliente::find($_POST['cliente_id']);
        }

        $router->render('cobros/mostrar', [
            'clientes' => $clientes,
            'clienteSeleccionado' => $clienteSeleccionado
        ]);
    }

    public static function seleccionarCliente(Router $router) {
        $alertas = [];
        $clientes = Cliente::all();
        $clienteSeleccionado = null;
        $ventaCliente = null;
        $productosVenta = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cliente_id'])) {
            $clienteSeleccionado = Cliente::find($_POST['cliente_id']);
            $ventaCliente = Venta::findVentaPorCliente($_POST['cliente_id']);

            //debug($ventaCliente);
            
            // Obtener todos los productos de venta
            $productosVenta = VentaProductos::all();

            foreach ($productosVenta as $productoVenta) {
                $productoVenta->producto = Producto::find($productoVenta->producto_id);
                $productoVenta->receta = Receta::find($productoVenta->receta_id);
                $productoVenta->venta = Venta::find($productoVenta->receta_id);  
            }
            
        }

        
        $alertas = Cobro::getAlertas();
    
        if (isset($_SESSION['msg'])) {
            $alertas = $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        

        $router->render('cobros/seleccionarCliente', [
            'clientes' => $clientes,
            'clienteSeleccionado' => $clienteSeleccionado,
            'ventaCliente' => $ventaCliente,
            'productosVenta' => $productosVenta,
            'alertas' => $alertas
        ]);
    }

    public static function guardarCobro(Router $router) {
        $alertas = [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cliente_id'])) {
            $clienteSeleccionado = Cliente::find($_POST['cliente_id']);
            $ventasCliente = Venta::findVentasPorCliente($_POST['cliente_id']);
            
            // Depuración para verificar las ventas del cliente
            //var_dump($ventasCliente);
    
            $cantidad_pagada = $_POST['cantidad_pagada'];
            $metodo_pago = $_POST['metodo_pago'];
    
            // Recuperar el valor de suma específico según el método de pago
            $sumas = json_decode($_POST['sumas'], true); // Decodificar el JSON a un arreglo asociativo
            $suma_total = isset($sumas[$metodo_pago]) ? $sumas[$metodo_pago] : 0; // Obtener el valor según el método de pago
    
            // Variable para almacenar la venta seleccionada
            $ventaSeleccionada = null;
    
            // Iterar sobre las ventas del cliente para encontrar una sin cobro vinculado
            if (is_array($ventasCliente)) {
                foreach ($ventasCliente as $ventaExistente) {
                    // Depuración para verificar cada venta
                    //var_dump($ventaExistente);
                    
                    if (is_object($ventaExistente) && property_exists($ventaExistente, 'id')) {
                        $cobroExistente = Cobro::findVenta($ventaExistente->id);
                        
                        // Si no hay un cobro existente, usar esta venta
                        if (!$cobroExistente) {
                            $ventaSeleccionada = $ventaExistente;
                            break; // Salir del bucle una vez que se encuentra una venta sin cobro vinculado
                        }
                    }
                }
            }
    
            // Depuración para verificar la venta seleccionada
            //var_dump($ventaSeleccionada);
    
            // Si no se encontró una venta sin cobro vinculado, manejar el caso
            if (!$ventaSeleccionada || !isset($ventaSeleccionada->id)) {
                Cobro::setAlerta('error', 'No se encontró una venta válida.');
                $_SESSION['msg'] = Cobro::getAlertas();
                header('Location: /cobros/seleccionarCliente');
                exit;
            }
    
            // Crear una instancia del cobro
            $cobro = new Cobro([
                'venta_id' => $ventaSeleccionada->id,
                'metodo_pago' => $metodo_pago,
                'cantidad_pagada' => $cantidad_pagada,
                'cantidad_por_pagar' => $suma_total,
                'cliente_id' => $clienteSeleccionado->id,
                'fecha_registro' => date('Y-m-d H:i:s')
            ]);

           
    
            if(intval($cantidad_pagada) < intval($suma_total)) {
                Cobro::setAlerta('info', 'El pago debe ser mayor o igual a la cantidad que debe');
                $_SESSION['msg'] = Cobro::getAlertas();
            } else {
                // Validar el cobro
                $errores = $cobro->validar();

                if (empty($errores)) {
                    // Establecer estado y debe
                    $cobro->setEstado();
                    $cobro->setDebe();
                    
                    // Guardar el cobro
                    $cobro->guardar();

                    Cobro::setAlerta('exito', 'El cobro se ha procesado correctamente.');
                    $_SESSION['msg'] = Cobro::getAlertas();
                } else {
                    // Hubo errores de validación, agregarlos a las alertas
                    foreach ($errores as $error) {
                        $alertas[] = $error;
                    }
                }
            }

            
        }
        
        // Obtener todos los clientes
        $clientes = Cliente::all();
    
        $alertas = Cobro::getAlertas();
    
        if (isset($_SESSION['msg'])) {
            $alertas = $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        
        // Renderizar la vista de seleccionarCliente con las alertas
        $router->render('cobros/seleccionarCliente', [
            'clientes' => $clientes,
            'alertas' => $alertas
        ]);
    }
    
    
    
    
    

}
