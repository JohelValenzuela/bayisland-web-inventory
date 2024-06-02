<?php

namespace Controllers;

use Model\Auth;
use Model\ReporteDefecto;
use Model\Producto;
use Model\Receta;
use Model\Venta;
use Model\VentaProductos;
use MVC\Router;

class ReporteDefectosController {
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

            //debug($reporte);
            $alertas = $reporte->validar();

            if (empty($alertas)) {
                $resultado = $reporte->guardar();
                if ($resultado) {
                    header('Location: /reportesDefectos');
                }
            }
        }

        foreach ($ventaProducto as $ventaProductos) {
            $ventaProductos->producto = Producto::find($ventaProductos->producto_id);
            $ventaProductos->receta = Receta::find($ventaProductos->receta_id);
            $ventaProductos->venta = Venta::find($ventaProductos->receta_id);
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
}
