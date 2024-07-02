<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Auth;
use Model\Bodegas;
use Model\DetallePedido;
use Model\Inventario;
use Model\MaestroPedido;
use Model\Producto;
use Model\Stock;
use MVC\Router;

class InventarioController {

    public static function mostrarStock(Router $router) {

        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }

        $alertas = [];

        $stock = Stock::all();

        $alertas = Stock::getAlertas();

            
        if (isset($_SESSION['msg'])) {
            $alertas = $_SESSION['msg'];
            unset($_SESSION['msg']); // Limpia la variable de sesión
        }


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
                'bodegas' => $bodegas,
                'alertas' => $alertas
            ]);
        } else {
            $router->render('stock/mostrar', []);
        }
    }

    public static function mostrar(Router $router) {

        
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }

        $user = $_SESSION['id'];

        if ($_SESSION['rol'] == 'Encargado') {
            $inventario = Inventario::allNombre(intval($user));
        } else if($_SESSION['rol'] == 'Administrador') {
            $inventario = Inventario::all();
        }

        
        if(!empty($inventario)){

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
            //debug($stock);
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
                $_SESSION['msg'] = Stock::getAlertas();
            }

            header('Location: /stock');

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
                $_SESSION['msg'] = Stock::getAlertas();
            }

            header('Location: /stock');

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

    public static function recibir(Router $router) {
        isAuth();
        if (!isAdmin()) {
            header('Location: /templates/error403');
            exit;
        }
    
        $id = validarORedireccionar('/pedido');  
        $detalle = MaestroPedido::find($id);

        $maestro = $detalle->id;
        $bodegaDestino = $detalle->bodegaId;
        $bodegaOrigen = 1;  // ID de la bodega origen
    
        // Obtener detalles del pedido según el pedidoId
        $detallesPedido = DetallePedido::findDetallePedido($maestro);
    
        $suficienteStock = true;
        foreach ($detallesPedido as $detalle) {
            $productoId = $detalle->productoId;
            $cantidad = $detalle->cantidad;
    
            // Verificar si existe stock suficiente en la bodega origen
            $stockBodegaOrigen = Stock::findStockBodega($productoId, $bodegaOrigen);
    
            if (!$stockBodegaOrigen || $stockBodegaOrigen->cantidad < $cantidad) {
                $suficienteStock = false;
                break;
            }
        }
    
        if ($suficienteStock) {
            foreach ($detallesPedido as $detalle) {
                $productoId = $detalle->productoId;
                $cantidad = $detalle->cantidad;
    
                // Restar la cantidad en la bodega origen
                $stockBodegaOrigen = Stock::findStockBodega($productoId, $bodegaOrigen);
                $stockBodegaOrigen->cantidad -= $cantidad;
                $resultado = $stockBodegaOrigen->actualizar();
    
                // Verificar si existe stock en la bodega destino
                $stockExistente = Stock::findStockBodega($productoId, $bodegaDestino);
    
                if ($stockExistente) {
                    // Si existe stock, actualizar la cantidad
                    $stockExistente->cantidad += $cantidad;
                    $resultado = $stockExistente->actualizar();
                } else {
                    // Si no existe stock, crear uno nuevo
                    $stockNuevo = new Stock();
                    $stockNuevo->productoId = $productoId;
                    $stockNuevo->bodegaId = $bodegaDestino;
                    $stockNuevo->cantidad = $cantidad;
                    $stockNuevo->estado = 'Activo';
                    $resultado = $stockNuevo->crear();
                }
    
                $kardex = Inventario::findStockBodega($productoId ?? 0 , $bodegaDestino ?? 0);
                $cantAnteriorInventario = intval($kardex->cantidadTotal ?? 0);
    
                if ($kardex) {
                    $referenciaDestino = $kardex->referencia;
                } else {
                    $referenciaDestino = uniqid();
                }
    
                // Registro en el inventario/kardex
                $inventario = new Inventario;
                $inventario->referencia = $referenciaDestino;
                $inventario->productoId = $productoId;
                $inventario->cantidadAnterior = $cantAnteriorInventario;
                $inventario->operacion = 'Entrada Pedido';
                $inventario->cantidadEntrada = $cantidad;
                $inventario->cantidadSalida = 0;
                $inventario->cantidadTotal = $cantAnteriorInventario + $cantidad;
                $inventario->estado = 'Activo';
                $inventario->usuarioId = $_SESSION['id'];
                $inventario->fechaCreacion = date('Y-m-d H:i:s');
                $inventario->bodegaId = $bodegaDestino;
                $resultado = $inventario->crear();
    
                // Registro en el inventario/kardex para bodega origen
                $kardexOrigen = Inventario::findStockBodega($productoId ?? 0 , $bodegaOrigen ?? 0);
                $cantAnteriorInventarioOrigen = intval($kardexOrigen->cantidadTotal ?? 0);
    
                if ($kardexOrigen) {
                    $referenciaOrigen = $kardexOrigen->referencia;
                } else {
                    $referenciaOrigen = uniqid();
                }

                $inventarioOrigen = new Inventario;
                $inventarioOrigen->referencia = $referenciaOrigen;
                $inventarioOrigen->productoId = $productoId;
                $inventarioOrigen->cantidadAnterior = $cantAnteriorInventarioOrigen;
                $inventarioOrigen->operacion = 'Salida Pedido';
                $inventarioOrigen->cantidadEntrada = 0;
                $inventarioOrigen->cantidadSalida = $cantidad;
                $inventarioOrigen->cantidadTotal = $cantAnteriorInventarioOrigen - $cantidad;
                $inventarioOrigen->estado = 'Activo';
                $inventarioOrigen->usuarioId = $_SESSION['id'];
                $inventarioOrigen->fechaCreacion = date('Y-m-d H:i:s');
                $inventarioOrigen->bodegaId = $bodegaOrigen;
                $resultado = $inventarioOrigen->crear();
            }

            $maestroEstado = MaestroPedido::find($maestro);
            $maestroEstado->estado = 'Recibido';
            $maestroEstado->actualizar();

    
            if ($resultado) {
                Stock::setAlerta('info', 'Se ha recibido el stock del pedido ' . $maestro . ' - ' . Bodegas::find($bodegaDestino)->nombre . ' - ' . Bodegas::find($bodegaDestino)->ubicacion);
                $_SESSION['msgPedido'] = Stock::getAlertas();
            }
    
            header('Location: /pedido');
        } else {
            Stock::setAlerta('error', 'No hay suficiente stock en la bodega 1 para completar el pedido.');
            $_SESSION['msgPedido'] = Stock::getAlertas();
            header('Location: /pedido');
        }

        
    
        // Redirigir o renderizar una vista según sea necesario
        $router->render('stock/recibir', [

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