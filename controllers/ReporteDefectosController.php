<?php

namespace Controllers;

use Model\Auth;
use Model\Inventario;
use Model\ReporteDefecto;
use Model\Producto;
use Model\Receta;
use Model\Stock;
use Model\Venta;
use Model\VentaProductos;
use MVC\Router;

class ReporteDefectosController {

    public static function mostrar(Router $router) {
        $reportes = ReporteDefecto::all();

        foreach ($reportes as $reporte) {
            $reporte->usuario = Auth::find($reporte->usuario_id);
            $reporte->producto = Producto::find($reporte->producto_id);
        }


        $router->render('reportesDefectos/mostrar', [
            'reportes' => $reportes
        ]);
    }
    
    public static function crear(Router $router) {
        $usuarios = Auth::all();
        $productos = Producto::all();
        $recetas = Receta::all();
        $ventaProducto = VentaProductos::all();

        $reporte = new ReporteDefecto;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reporte->sincronizar($_POST);

            date_default_timezone_set('America/Costa_Rica');
            $reporte->fecha_reporte = date('Y-m-d H:i:s');

            $alertas = $reporte->validar();

            if (empty($alertas)) {
                $resultado = $reporte->guardar();
                if ($resultado) {
                    ReporteDefecto::setAlerta('exito', 'Reporte Creado');
                    $_SESSION['msg'] = ReporteDefecto::getAlertas();
                }
            }
        }

        foreach ($ventaProducto as $ventaProductos) {
            $ventaProductos->producto = Producto::find($ventaProductos->producto_id);
            $ventaProductos->receta = Receta::find($ventaProductos->receta_id);
            $ventaProductos->venta = Venta::find($ventaProductos->receta_id);
        }

        $alertas = ReporteDefecto::getAlertas();

        if (isset($_SESSION['msg'])) {
            $alertas = $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        $router->render('reportesDefectos/crear', [
            'usuarios' => $usuarios,
            'productos' => $productos,
            'recetas' => $recetas,
            'reporte' => $reporte,
            'alertas' => $alertas,
            'ventaProducto' => $ventaProducto
        ]);
    }

    public static function aprobar(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $reporte = ReporteDefecto::find($id);
            if ($reporte) {
                $stock = Stock::findStock($reporte->producto_id);
                if ($stock) {
                    $stock->cantidad -= $reporte->cantidad;
                    $stock->movimiento = 'Salida';
                    $stock->estado = 'Activo';
                    $stock->guardar();
                    $reporte->estado = 'aprobado';
                    $reporte->guardar();
                }
            }
            
            // Registrar la salida en el kardex
            $productoStock = Stock::findStock($reporte->producto_id);
            if ($productoStock) {

                $ultimaEntrada = Inventario::findRegistro($productoStock->productoId);
                $referenciaAnterior = $ultimaEntrada ? $ultimaEntrada->referencia : '';
                
                $kardex = new Inventario();
                $kardex->referencia = $referenciaAnterior;
                $kardex->productoId = $productoStock->productoId;
                $kardex->cantidadAnterior = $ultimaEntrada ? $ultimaEntrada->cantidadTotal : 0;
                $kardex->operacion = 'Defecto';
                $kardex->cantidadEntrada = 0;
                $kardex->cantidadSalida = $reporte->cantidad;
                $kardex->cantidadTotal = $kardex->cantidadAnterior - $kardex->cantidadSalida;
                $kardex->estado = 'Activo';
                $kardex->usuarioId = $_SESSION['id'];
                $kardex->fechaCreacion = date('Y-m-d H:i:s');
                $kardex->guardar();
                //debug($kardex);

                header('Location: /reportesDefectos');
            }
        }
    }

    public static function rechazar(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $reporte = ReporteDefecto::find($id);
            if ($reporte) {
                $reporte->estado = 'rechazado';
                $reporte->guardar();
            }
            header('Location: /reportesDefectos');
        }
    }
}
