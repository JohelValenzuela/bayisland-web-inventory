<?php

namespace Controllers;

use Model\Auth;
use Model\Bodegas;
use Model\Cliente;
use Model\Inventario;
use Model\Producto;
use Model\Regalia;
use Model\Stock;
use MVC\Router;

class RegaliasController {

    public static function mostrar(Router $router) {
        $regalias = Regalia::all();
        $bodegas = Bodegas::all();

        foreach ($regalias as $regalia) {
            $regalia->usuario = Auth::find($regalia->usuario_id);
            $regalia->producto = Producto::find($regalia->producto_id);
        }


        $router->render('regalias/mostrar', [
            'regalias' => $regalias,
            'bodegas' => $bodegas
        ]);
    }

    public static function crear(Router $router) {

        $alertas = [];
        
        $regalia = new Regalia();
        $usuarios = Auth::all();
        $clientes = Cliente::all();
        $productos = Producto::all();
        $bodegas = Bodegas::all();

        date_default_timezone_set('America/Costa_Rica');
        $regalia->fecha_regalia = date('Y-m-d H:i:s');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $regalia->sincronizar($_POST);
            $alertas = $regalia->validar();

            //debug($regalia);

            if (empty($alertas)) {
                $resultado = $regalia->guardar();
                if ($resultado) {
                    Regalia::setAlerta('exito', 'Reporte Creado');
                    $_SESSION['msg'] = Regalia::getAlertas();
                }
                
            }
        }

        $alertas = Regalia::getAlertas();

        if (isset($_SESSION['msg'])) {
            $alertas = $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        $router->render('regalias/crear', [
            'regalia' => $regalia,
            'clientes' => $clientes,
            'productos' => $productos,
            'alertas' => $alertas,
            'usuarios' => $usuarios,
            'bodegas' => $bodegas
        ]);
    }

    public static function aprobar(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $regalia = Regalia::find($id);
            if ($regalia) {
                $stock = Stock::findStockBodega($regalia->producto_id, $regalia->bodegaId);
                if ($stock) {
                    $stock->cantidad -= $regalia->cantidad;
                    $stock->movimiento = 'Salida';
                    $stock->estado = 'Activo';
                    $stock->guardar();
                    $regalia->estado = 'aprobado';
                    $regalia->guardar();
                }
            }

            // Registrar la salida en el kardex
            $productoStock = Stock::findStockBodega($regalia->producto_id, $regalia->bodegaId);
            if ($productoStock) {

                $ultimaEntrada = Inventario::findStockBodega($productoStock->productoId, $regalia->bodegaId);
                $referenciaAnterior = $ultimaEntrada ? $ultimaEntrada->referencia : '';
                
                
                $kardex = new Inventario();
                $kardex->referencia = $referenciaAnterior;
                $kardex->productoId = $productoStock->productoId;
                $kardex->cantidadAnterior = $ultimaEntrada->cantidadTotal;
                $kardex->operacion = 'Regalía';
                $kardex->cantidadEntrada = 0;
                $kardex->cantidadSalida = $regalia->cantidad;
                $kardex->cantidadTotal = $kardex->cantidadAnterior - $kardex->cantidadSalida;
                $kardex->estado = 'Activo';
                $kardex->usuarioId = $_SESSION['id'];
                $kardex->fechaCreacion = date('Y-m-d H:i:s');
                $kardex->bodegaId = $regalia->bodegaId;
                $kardex->guardar();
                
                //debug($kardex);



                header('Location: /regalias');
            }

            
        }
    }

    public static function rechazar(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $regalia = Regalia::find($id);
            if ($regalia) {
                $regalia->estado = 'rechazado';
                $regalia->guardar();
            }
            header('Location: /regalias');
        }
    }
    
}
