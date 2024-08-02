<?php

namespace Controllers;

use Model\Auth;
use Model\Bodegas;
use Model\Cliente;
use Model\Inventario;
use Model\Producto;
use Model\Receta;
use Model\Regalia;
use Model\Stock;
use MVC\Router;

class RegaliasController {

    public static function mostrar(Router $router) {
        isAuth();
        if (!tieneRol()) {
            header('Location: /templates/error403');
        }

        $user = $_SESSION['id'];

        if ($_SESSION['rol'] == 'Encargado') {
            $regalias = Regalia::porUsuario(intval($user));
        } else if ($_SESSION['rol'] == 'Administrador') {
            $regalias = Regalia::all();
        }

        $bodegas = Bodegas::all();

        foreach ($regalias as $regalia) {
            $regalia->usuario = Auth::find($regalia->usuario_id);
            $regalia->producto = Producto::find($regalia->producto_id);
            $regalia->receta = Receta::find($regalia->receta_id); // Cargar receta si existe
        }

        $router->render('regalias/mostrar', [
            'regalias' => $regalias,
            'bodegas' => $bodegas
        ]);
    }

    public static function crear(Router $router) {
        isAuth();
        if (!tieneRol()) {
            header('Location: /templates/error403');
        }

        $alertas = [];
        
        $regalia = new Regalia();
        $usuarios = Auth::all();
        $clientes = Cliente::all();
        $productos = Producto::all();
        $recetas = Receta::all();
        $bodegas = Bodegas::all();

        date_default_timezone_set('America/Costa_Rica');
        $regalia->fecha_regalia = date('Y-m-d H:i:s');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $regalia->sincronizar($_POST);
            
            $productoOrReceta = $_POST['productoOrReceta'];
            list($tipo, $id) = explode('-', $productoOrReceta);
            if ($tipo === 'producto') {
                $regalia->producto_id = intval($id);
                $regalia->receta_id = 0;
            } elseif ($tipo === 'receta') {
                $regalia->receta_id = intval($id);
                $regalia->producto_id = 0;
            }

            $alertas = $regalia->validar();

            if (empty($alertas)) {
                $resultado = $regalia->guardar();
                if ($resultado) {
                    Regalia::setAlerta('exito', 'Regalía Creada');
                    $_SESSION['msg'] = Regalia::getAlertas();
                    header('Location: /regalias');
                    exit;
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
            'recetas' => $recetas,
            'alertas' => $alertas,
            'usuarios' => $usuarios,
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
            $regalia = Regalia::find($id);
            if ($regalia) {
                if ($regalia->producto_id != 0) {
                    // Manejo del producto
                    $stock = Stock::findStockBodega($regalia->producto_id, $regalia->bodegaId);
                    if ($stock) {
                        $stock->cantidad -= $regalia->cantidad;
                        $stock->movimiento = 'Salida';
                        $stock->estado = 'Activo';
                        $stock->guardar();
                    }
    
                    // Registrar la salida en el kardex
                    $productoStock = Stock::findStockBodega($regalia->producto_id, $regalia->bodegaId);
                    if ($productoStock) {
                        $ultimaEntrada = Inventario::findStockBodega($productoStock->productoId, $regalia->bodegaId);
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
                        $kardex->bodegaId = $regalia->bodegaId;
                        $kardex->guardar();
                    }
    
                } elseif ($regalia->receta_id != 0) {
                    // Manejo de la receta
                    $ingredientes = Receta::findIngredientesReceta($regalia->receta_id);
                    foreach ($ingredientes as $ingrediente) {
                        $producto_id = $ingrediente->productoId;
                        $cantidad = $ingrediente->cantidad * $regalia->cantidad;

                        
                        $stock = Stock::findStockBodega($producto_id, $regalia->bodegaId);
                        if ($stock) {
                            $stock->cantidad =- $cantidad;
                            $stock->movimiento = 'Salida';
                            $stock->estado = 'Activo';
                            $stock->guardar();
                            
                            // Registrar la salida en el kardex
                            $productoStock = Stock::findStockBodega($producto_id, $regalia->bodegaId);
                            if ($productoStock) {
                                $ultimaEntrada = Inventario::findStockBodega($productoStock->productoId, $regalia->bodegaId);
                                $referenciaAnterior = $ultimaEntrada ? $ultimaEntrada->referencia : '';
                                
                                $kardex = new Inventario();
                                $kardex->referencia = $referenciaAnterior;
                                $kardex->productoId = $producto_id;
                                $kardex->cantidadAnterior = $ultimaEntrada ? $ultimaEntrada->cantidadTotal : 0;
                                $kardex->operacion = 'Regalía';
                                $kardex->cantidadEntrada = 0;
                                $kardex->cantidadSalida = $cantidad;
                                $kardex->cantidadTotal = $kardex->cantidadAnterior - $kardex->cantidadSalida;
                                $kardex->estado = 'Activo';
                                $kardex->usuarioId = $_SESSION['id'];
                                $kardex->fechaCreacion = date('Y-m-d H:i:s');
                                $kardex->bodegaId = $regalia->bodegaId;
                                $kardex->guardar();
                            }
                        }
                    }
    
                    $regalia->estado = 'aprobado';
                    $regalia->guardar();
                }
            }
    
            header('Location: /regalias');
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
            $regalia = Regalia::find($id);
            if ($regalia) {
                $regalia->estado = 'rechazado';
                $regalia->guardar();
            }
            header('Location: /regalias');
        }
    }
}
