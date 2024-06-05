<?php

namespace Controllers;

use Model\Auth;
use Model\Cliente;
use Model\Inventario;
use Model\Producto;
use Model\Regalia;
use Model\Stock;
use MVC\Router;

class RegaliasController {

    public static function mostrar(Router $router) {
        $regalias = Regalia::all();

        foreach ($regalias as $regalia) {
            $regalia->usuario = Auth::find($regalia->usuario_id);
            $regalia->producto = Producto::find($regalia->producto_id);
        }


        $router->render('regalias/mostrar', [
            'regalias' => $regalias
        ]);
    }

    public static function crear(Router $router) {

        $alertas = [];
        
        $regalia = new Regalia();
        $usuarios = Auth::all();
        $clientes = Cliente::all();
        $productos = Producto::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $regalia->sincronizar($_POST);
            $alertas = $regalia->validar();

            //debug($regalia);

            if (empty($alertas)) {
                $regalia->guardar();
                header('Location: /regalias');
            }
        }

        $router->render('regalias/crear', [
            'regalia' => $regalia,
            'clientes' => $clientes,
            'productos' => $productos,
            'alertas' => $alertas,
            'usuarios' => $usuarios,
        ]);
    }

    public static function aprobar(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $regalia = Regalia::find($id);
            if ($regalia) {
                $stock = Stock::findStock($regalia->producto_id);
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
            $productoStock = Stock::findStock($regalia->producto_id);
            if ($productoStock) {

                $ultimaEntrada = Inventario::findRegistro($productoStock->productoId);
                $referenciaAnterior = $ultimaEntrada ? $ultimaEntrada->referencia : '';
                

                $kardex = new Inventario();
                $kardex->referencia = $referenciaAnterior;
                $kardex->productoId = $productoStock->productoId;
                $kardex->cantidadAnterior = $ultimaEntrada ? $ultimaEntrada->cantidadTotal : 0;
                $kardex->operacion = 'Regalía';
                $kardex->cantidadEntrada = 0;
                $kardex->cantidadSalida = $regalia->cantidad;
                $kardex->cantidadTotal = $kardex->cantidadAnterior - $kardex->cantidadSalida;
                $kardex->estado = 'Activo';
                $kardex->usuarioId = $_SESSION['id'];
                $kardex->fechaCreacion = date('Y-m-d H:i:s');
                //debug($kardex);
                $kardex->guardar();


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
