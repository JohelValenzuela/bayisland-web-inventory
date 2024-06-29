<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Auth;
use Model\Bodegas;
use Model\Inventario;
use Model\Producto;
use Model\Stock;
use MVC\Router;

class InventarioController {

    // MOSTRAR STOCK
    public static function mostrarStock(Router $router) {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $stock = Stock::all();
        if(!empty($stock)){

            $producto = Producto::all();
            $usuarios = Auth::all();
            $bodegas = Bodegas::all();
            
            foreach ($stock as $stocks) {
                $stocks->producto = Producto::find($stocks->productoId);
                $stocks->usuario = Auth::find($stocks->usuarioId);
                $stocks->bodega = Bodegas::find($stocks->bodegaId);
            }

            $router->render('stock/mostrar', [
                'stock' => $stock,
                'producto' => $producto,
                'usuarios' => $usuarios,
                'bodegas' => $bodegas
            ]);
        } else {
            $router->render('stock/mostrar', []);
        }
    }

    // MOSTRAR INVENTARIOS
    public static function mostrar(Router $router) {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $inventario = Inventario::all();
        if(!empty($inventario)){

                   
            $inventario = Inventario::all();
            $producto = Producto::all();
            $usuarios = Auth::all();
            $bodegas = Bodegas::all();

            foreach ($inventario as $inventarios) {
                $inventarios->producto = Producto::find($inventarios->productoId);
                $inventarios->usuario = Auth::find($inventarios->usuarioId);
                $inventarios->bodega = Bodegas::find($inventarios->bodegaId);
            }


            $router->render('inventario/mostrar', [
                'inventario' => $inventario,
                'producto' => $producto,
                'usuarios' => $usuarios,
                'bodegas' => $bodegas,
            ]);
        } else {
            $router->render('inventario/mostrar', []);
        }
    }

    //NUEVO STOCK
    public static function nuevoStock(Router $router){
        
        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $alertas = [];
        $producto = Producto::all();
        $usuarios = Auth::all();
        $bodegas = Bodegas::all();

        $stock = new Stock;
        $inventario = new Inventario;

        $resultado = $stock->existeStock($_POST['productoId'] ?? 0 , $_POST['bodegaId'] ?? 0);
        
        $stock->estado = "Activo";
        $inventario->estado = "Activo";

        
        if($resultado->num_rows) { // SI EXISTE - SOLO AGREGA LA CANTIDAD
            
            $stock = Stock::findStockBodega($_POST['productoId'], $_POST['bodegaId']); // Busco el id del producto seleccionado
            $cantStockAnterior = $stock->cantidad ?? 0; // Almaceno la cantidad del produto de la DB
            
            $movimiento = 'Entrada';
            date_default_timezone_set('America/Costa_Rica');
            $fechaActual = date(format:'Y-m-d H:i:s');
            $usuario = $_SESSION['id'];

            $stock->movimiento = $movimiento;
            $stock->fechaCreacion = $fechaActual;
            $stock->usuarioId = $usuario;
            //$stock->estado = $_POST['estado'];
            
            
            //*** INVENTARIOS KARDEX */
            $cantTemporal = Inventario::findStockBodega($stock->productoId ?? 0 , $_POST['bodegaId'] ?? 0);
            $cantAnteriorInventario = intval($cantTemporal->cantidadTotal ?? 0);
            $referenciaAnterior = $cantTemporal->referencia;
            
            $inventario->sincronizar($_POST);
            $alertas = $inventario->validar();
            
            
            $cantProducto = $inventario->calculoCantidad('producto', 'id', $inventario->productoId);
            $cantPorProducto = intval($cantProducto->cantidad); // Cantidad de unidades por producto
            
            $inventario->cantidadAnterior = $cantAnteriorInventario;
            
            $inventario->cantidadEntrada = $cantPorProducto * intval($_POST['cantidad']);  // Cantidad de Entrada
            $inventario->cantidadSalida = 0; // Cantidad de Salida
            
            $inventario->cantidadTotal = $inventario->cantidadEntrada + $inventario->cantidadAnterior;
            
            $inventario->referencia = $referenciaAnterior;
            $inventario->operacion = $movimiento;
            $inventario->fechaCreacion = $fechaActual;
            $inventario->usuarioId = $usuario;
            
            //debug($inventario);
            /*** FIN INVENTARIOS KARDEX */
            
            
            $cantIngresada = $cantPorProducto * intval($_POST['cantidad']); // Almaceno la cantidad que se está ingresando
            $cantNueva = (intval($cantStockAnterior) + intval($cantIngresada)); // Se realiza el calculo de la nueva cantidad
            $stock->cantidad = $cantNueva;

            $resultado = $inventario->crear();
            $resultado = $stock->actualizar();
        
            if($resultado) {                
                Stock::setAlerta('exito', 'Se han agregado ' . $cantIngresada  . ' productos al stock ');
                Stock::setAlerta('exito', 'Cantidad en stock: ' . $cantNueva);
            }

            //exit('EXISTE');

        } else { //NO EXISTE -- LO CREA NUEVO
            $cantidadAnterior = $stock->cantidad;     

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $stock->sincronizar($_POST);
                $alertas = $stock->validar();
                
                $inventario->sincronizar($_POST);
                
                $alertas = $inventario->validar();
                
                
                // Revisa que alertas esté vacio
                if(empty($alertas)) {
                    
                    $referencia = uniqid();
                    $movimiento = 'Entrada';
                    date_default_timezone_set('America/Costa_Rica');
                    $fechaActual = date(format:'Y-m-d H:i:s');
                    $usuario = $_SESSION['id'];
                    
                    
                    $cantidad = intval($cantidadAnterior ?? 0) + intval($_POST['cantidad']);
                    $stock->cantidad = $cantidad;
                    
                    $stock->movimiento = $movimiento;
                    $stock->fechaCreacion = $fechaActual;
                    $stock->usuarioId = $usuario;
                    
                    
                    /*** INVENTARIOS KARDEX */
                        $cantProducto = $inventario->calculoCantidad('producto', 'id', $inventario->productoId);
                        $cantPorProducto = intval($cantProducto->cantidad); // Cantidad de unidades por producto
                        
                        $inventario->cantidadAnterior = 0;
    
                        $inventario->cantidadEntrada = $cantPorProducto * intval($_POST['cantidad']);  // Cantidad de Entrada
                        $inventario->cantidadSalida = 0; // Cantidad de Salida
                        
                        $inventario->cantidadTotal = $inventario->cantidadEntrada + $inventario->cantidadAnterior;
                        
                        $inventario->referencia = $referencia;
                        $inventario->operacion = $movimiento;
                        $inventario->fechaCreacion = $fechaActual;
                        $inventario->usuarioId = $usuario;
                        
                        
                        
                        $cantIngresada = $cantPorProducto * intval($_POST['cantidad']); // Almaceno la cantidad que se está ingresando
                        $stock->cantidad = $cantIngresada;
                        
                        //debug($stock);
                        //debug($inventario);
    
                    /*** FIN INVENTARIOS KARDEX */
    
                    $resultado = $stock->crear();
                    $resultado = $inventario->crear();
                    
                    if($resultado) {                
                        Stock::setAlerta('exito', 'Se han agregado ' . $stock->cantidad . ' productos al stock');
                    }
                }
            }
        }
        

        
             

        $alertas = Stock::getAlertas();
        $router->render('stock/nuevoStock', [
            'producto' => $producto,
            'stock' => $stock,
            'inventario' => $inventario,
            'usuarios' => $usuarios,
            'alertas' => $alertas,
            'bodegas' => $bodegas
        ]);
    }

    public static function nuevaSalida(Router $router){
        
        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $alertas = [];
        $producto = Producto::all();
        $usuarios = Auth::all();
        $bodegas = Bodegas::all();

        $stock = new Stock;
        $inventario = new Inventario;

        $resultado = $stock->existeStock($_POST['productoId'] ?? 0 , $_POST['bodegaId'] ?? 0);
        
        $stock->estado = "Activo";
        $inventario->estado = "Activo";
        
        
        if($resultado->num_rows) { // SI EXISTE - SOLO AGREGA LA CANTIDAD
            
            $stock = Stock::findStockBodega($_POST['productoId'], $_POST['bodegaId']); // Busco el id del producto seleccionado
            $cantStockAnterior = $stock->cantidad ?? 0; // Almaceno la cantidad del produto de la DB
            
            $movimiento = 'Salida';
            date_default_timezone_set('America/Costa_Rica');
            $fechaActual = date(format:'Y-m-d H:i:s');
            $usuario = $_SESSION['id'];

            $stock->movimiento = $movimiento;
            $stock->fechaCreacion = $fechaActual;
            $stock->usuarioId = $usuario;
            //$stock->estado = $_POST['estado'];
            
            
            
            //*** INVENTARIOS KARDEX */
            $cantTemporal = Inventario::findStockBodega($stock->productoId ?? 0 , $_POST['bodegaId'] ?? 0);
            $cantAnteriorInventario = intval($cantTemporal->cantidadTotal ?? 0);
            $referenciaAnterior = $cantTemporal->referencia;
            
            $inventario->sincronizar($_POST);
            $alertas = $inventario->validar();
            
            
            $cantProducto = $inventario->calculoCantidad('producto', 'id', $inventario->productoId);
            $cantPorProducto = intval($cantProducto->cantidad); // Cantidad de unidades por producto
            
            $inventario->cantidadAnterior = $cantAnteriorInventario;
            
            $inventario->cantidadEntrada = 0;  // Cantidad de Entrada
            $inventario->cantidadSalida = intval($_POST['cantidad']); // Cantidad de Salida
            
            $inventario->cantidadTotal = $inventario->cantidadAnterior - $inventario->cantidadSalida;
            
            $inventario->referencia = $referenciaAnterior;
            $inventario->operacion = $movimiento;
            $inventario->fechaCreacion = $fechaActual;
            $inventario->usuarioId = $usuario;
            
            /*** FIN INVENTARIOS KARDEX */
            
            $stock->cantidad = $inventario->cantidadTotal;

            $resultado = $inventario->crear();
            $resultado = $stock->actualizar();
        
            if($resultado) {                
                Stock::setAlerta('exito', 'Se han retirado ' . $inventario->cantidadSalida  . ' productos del stock ');
                Stock::setAlerta('exito', 'Cantidad en stock: ' . $inventario->cantidadTotal);
            }

            //exit('EXISTE');

        } 

        $alertas = Stock::getAlertas();
        $router->render('stock/nuevaSalida', [
            'producto' => $producto,
            'stock' => $stock,
            'inventario' => $inventario,
            'usuarios' => $usuarios,
            'alertas' => $alertas,
            'bodegas' => $bodegas
        ]);
    }


}


























    





//     public static function actualizar(Router $router) {

//         isAuth();
//         if(!isAdmin()) {
//             header('Location: /templates/error403');
//         }

//         $categoria = Categoria::all();


//         $id = validarORedireccionar('/producto'); 
//         $producto = Producto::find($id);
        

//         $alertas = [];

//         if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
//             $producto->sincronizar($_POST);
            
//             $alertas = $producto->validar();

//             $totalMedida = $producto->totalMedida; // Cantidad de Medida (Onza)
//             $precioMedida = $producto->precioMedida; // Precio por Medida (Onza)
//             $precioUnidad = $producto->precioUnidad; // Precio por Producto
//             $subtotal = $totalMedida * $precioMedida; // Subtotal
//             $total = $subtotal + $precioUnidad;

//             $producto->total = $total;
            
                   
//             // REVISA QUE EL ARRAY DE ERRORES ESTE VACIO
//             if(empty($alertas)){
                
//                 // Se llama la funcion para guardar en la DB
//                 $resultado = $producto->guardar();
                
//                 if($resultado) { // Si se guarda el usuario envia una alerta
//                     Producto::setAlerta('exito', 'Se ha actualizado el producto');
//                     //header('Location: /producto');
//                 }
//             }
//         }
//         $alertas = Producto::getAlertas();
//         $router->render('producto/actualizar', [
//             'categoria' => $categoria,
//             'medidas' => $medidas,
//             'producto' => $producto,
//             'alertas' => $alertas
//         ]);
//     }




// }