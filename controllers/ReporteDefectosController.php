<?php

namespace Controllers;

use Model\Auth;
use Model\Bodegas;
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
        isAuth();
        if (!tieneRol()) {
            header('Location: /templates/error403');
        }

        $user = $_SESSION['id'];

        if ($_SESSION['rol'] == 'Encargado') {
            $reportes = ReporteDefecto::porUsuario(intval($user));
        } else if ($_SESSION['rol'] == 'Administrador') {
            $reportes = ReporteDefecto::all();
        }

        $bodegas = Bodegas::all();

        foreach ($reportes as $reporte) {
            $reporte->usuario = Auth::find($reporte->usuario_id);
            $reporte->producto = Producto::find($reporte->producto_id);
            $reporte->receta = Receta::find($reporte->receta_id);
        }

        $router->render('reportesDefectos/mostrar', [
            'reportes' => $reportes,
            'bodegas' => $bodegas
        ]);
    }

    public static function crear(Router $router) {
        isAuth();
        if (!tieneRol()) {
            header('Location: /templates/error403');
        }

        $usuarios = Auth::all();
        $productos = Producto::all();
        $recetas = Receta::all();
        $ventaProducto = VentaProductos::all();
        $bodegas = Bodegas::all();

        $reporte = new ReporteDefecto;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reporte->sincronizar($_POST);
            
            date_default_timezone_set('America/Costa_Rica');
            $reporte->fecha_reporte = date('Y-m-d H:i:s');
            
            $productoOrReceta = $_POST['productoOrReceta'];
            list($tipo, $id) = explode('-', $productoOrReceta);
            if ($tipo === 'producto') {
                $reporte->producto_id = intval($id);
                $reporte->receta_id = 0;
            } elseif ($tipo === 'receta') {
                $reporte->receta_id = intval($id);
                $reporte->producto_id = 0;
            }

            $alertas = $reporte->validar();

            if (empty($alertas)) {
                $resultado = $reporte->guardar();
                if ($resultado) {
                    ReporteDefecto::setAlerta('exito', 'Reporte Creado');
                    $_SESSION['msg'] = ReporteDefecto::getAlertas();
                    header('Location: /reportesDefectos');
                    exit;
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
            'ventaProducto' => $ventaProducto,
            'bodegas' => $bodegas
        ]);
    }

    public static function aprobar(Router $router) {
        isAuth();
        if (!isAdmin()) {
            header('Location: /templates/error403');
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $reporte = ReporteDefecto::find($id);
            if ($reporte) {
                // Manejo del producto
                if ($reporte->producto_id != 0) {
                    $stock = Stock::findStockBodega($reporte->producto_id, $reporte->bodegaId);
                    if ($stock) {
                        $stock->cantidad -= $reporte->cantidad;
                        $stock->movimiento = 'Salida';
                        $stock->estado = 'Activo';
                        $stock->guardar();
                    }
    
                    // Registrar la salida en el kardex
                    $productoStock = Stock::findStockBodega($reporte->producto_id, $reporte->bodegaId);
                    if ($productoStock) {
                        $ultimaEntrada = Inventario::findStockBodega($productoStock->productoId, $reporte->bodegaId);
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
                        $kardex->bodegaId = $reporte->bodegaId;
                        $kardex->guardar();
                    }
    
                // Manejo de la receta
                } elseif ($reporte->receta_id != 0) {
                    $ingredientes = Receta::findIngredientesReceta($reporte->receta_id);
                    foreach ($ingredientes as $ingrediente) {
                        $producto_id = $ingrediente->productoId;
                        $cantidad = $ingrediente->cantidad * $reporte->cantidad;
    
                        $stock = Stock::findStockBodega($producto_id, $reporte->bodegaId);
                        if ($stock) {
                            $stock->cantidad -= $cantidad;
                            $stock->movimiento = 'Salida';
                            $stock->estado = 'Activo';
                            $stock->guardar();
    
                            // Registrar la salida en el kardex
                            $productoStock = Stock::findStockBodega($producto_id, $reporte->bodegaId);
                            if ($productoStock) {
                                $ultimaEntrada = Inventario::findStockBodega($productoStock->productoId, $reporte->bodegaId);
                                $referenciaAnterior = $ultimaEntrada ? $ultimaEntrada->referencia : '';
    
                                $kardex = new Inventario();
                                $kardex->referencia = $referenciaAnterior;
                                $kardex->productoId = $producto_id;
                                $kardex->cantidadAnterior = $ultimaEntrada ? $ultimaEntrada->cantidadTotal : 0;
                                $kardex->operacion = 'Defecto';
                                $kardex->cantidadEntrada = 0;
                                $kardex->cantidadSalida = $cantidad;
                                $kardex->cantidadTotal = $kardex->cantidadAnterior - $kardex->cantidadSalida;
                                $kardex->estado = 'Activo';
                                $kardex->usuarioId = $_SESSION['id'];
                                $kardex->fechaCreacion = date('Y-m-d H:i:s');
                                $kardex->bodegaId = $reporte->bodegaId;
                                $kardex->guardar();
                            }
                        }
                    }
    
                    $reporte->estado = 'aprobado';
                    $reporte->guardar();
                }
            }
    
            header('Location: /reportesDefectos');
        }
    }
    

    public static function rechazar(Router $router) {
        isAuth();
        if (!isAdmin()) {
            header('Location: /templates/error403');
            exit;
        }

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
