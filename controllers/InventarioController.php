<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Auth;
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

            foreach ($stock as $stocks) {
                $stocks->producto = Producto::find($stocks->productoId);
                $stocks->usuario = Auth::find($stocks->usuarioId);
            }

            $router->render('stock/mostrar', [
                'stock' => $stock,
                'producto' => $producto,
                'usuarios' => $usuarios
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

            foreach ($inventario as $inventarios) {
                $inventarios->producto = Producto::find($inventarios->productoId);
                $inventarios->usuario = Auth::find($inventarios->usuarioId);
                //debug($usuarios);
            }


            $router->render('inventario/mostrar', [
                'inventario' => $inventario,
                'producto' => $producto,
                'usuarios' => $usuarios
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

        $stock = new Stock;
        $inventario = new Inventario;

        $resultado = $stock->existeStock($_POST['productoId'] ?? 0);
        
        $stock->estado = "Activo";
        $inventario->estado = "Activo";


        if($resultado->num_rows) { // SI EXISTE - SOLO AGREGA LA CANTIDAD
            
            $stock = Stock::findStock($_POST['productoId']); // Busco el id del producto seleccionado
            $cantStockAnterior = $stock->cantidad; // Almaceno la cantidad del produto de la DB



            $movimiento = 'Entrada';
            date_default_timezone_set('America/Costa_Rica');
            $fechaActual = date(format:'Y-m-d H:i:s');
            $usuario = $_SESSION['id'];

            $stock->movimiento = $movimiento;
            $stock->fechaCreacion = $fechaActual;
            $stock->usuarioId = $usuario;
            //$stock->estado = $_POST['estado'];
            

            //*** INVENTARIOS KARDEX */

            $cantTemporal = Inventario::findRegistro($stock->productoId ?? 0);
            $cantAnteriorInventario = intval($cantTemporal->cantidadTotal ?? 0);
            $referenciaAnterior = $cantTemporal->referencia;

            //debug($cantTemporal);
                  
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
            'alertas' => $alertas
        ]);
    }

    // ENTRADA STOCK
    public static function entradaStock(Router $router) {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $alertas = [];
        $producto = Producto::all();
        $usuarios = Auth::all();

        $id = validarORedireccionar('/stock');   
        $stock = Stock::find($id);

        $inventario = new Inventario;

        $cantTemporal = Inventario::findRegistro($stock->productoId ?? 0);
        $cantAnteriorInventario = intval($cantTemporal->cantidadTotal ?? 0);
        $referenciaAnterior = $cantTemporal->referencia;

        //debug($cantTemporal);

        $cantidadAnterior = $stock->cantidad ?? 0;

        $stock->estado = "Activo";
        $inventario->estado = "Activo";
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $stock->sincronizar($_POST);
            $alertas = $stock->validar();

            $inventario->sincronizar($_POST);           
            $alertas = $inventario->validar();
                  

            // Revisa que alertas esté vacio
            if(empty($alertas)) {

                $referencia = $referenciaAnterior;
                $movimiento = 'Entrada';
                date_default_timezone_set('America/Costa_Rica');
                $fechaActual = date(format:'Y-m-d h:i:s');
                $usuario = $_SESSION['id'];

                $stock->movimiento = $movimiento;
                $stock->fechaCreacion = $fechaActual;
                $stock->usuarioId = $usuario;



                /*** INVENTARIOS KARDEX */
                    $cantProducto = $inventario->calculoCantidad('producto', 'id', $inventario->productoId);
                    $cantPorProducto = intval($cantProducto->cantidad); // Cantidad de unidades por producto

                    $inventario->cantidadAnterior = $cantAnteriorInventario;

                    $inventario->cantidadEntrada = $cantPorProducto * intval($_POST['cantidad']);  // Cantidad de Entrada
                    $inventario->cantidadSalida = 0; // Cantidad de Salida
                                           
                    $inventario->cantidadTotal = $inventario->cantidadEntrada + $cantAnteriorInventario;

                    $inventario->referencia = $referencia;
                    $inventario->operacion = $movimiento;
                    $inventario->fechaCreacion = $fechaActual;
                    $inventario->usuarioId = $usuario;

                    $cantidad = intval($cantidadAnterior ?? 0) + intval($_POST['cantidad']);
                    $stock->cantidad = $cantidad;
    
                    $cantIngresada = $cantPorProducto * intval($_POST['cantidad']); // Almaceno la cantidad que se está ingresando
                    $cantNueva = (intval($cantidadAnterior) + intval($cantIngresada)); // Se realiza el calculo de la nueva cantidad
                    $stock->cantidad = $cantNueva;

                /*** FIN INVENTARIOS KARDEX */
                //debug($inventario);

                $resultado = $stock->actualizar();
                $resultado = $inventario->crear();
                
                if($resultado) {                
                    Stock::setAlerta('exito', 'Se han agregado ' . $inventario->cantidadEntrada . ' productos al stock ' . ' [' . $_POST['cantidad'] . ' empaques'. ']');
                }
            }
        }
             

        $alertas = Stock::getAlertas();
        $router->render('stock/entradaStock', [
            'producto' => $producto,
            'stock' => $stock,
            'inventario' => $inventario,
            'usuarios' => $usuarios,
            'alertas' => $alertas
        ]);
    }

    public static function salidaStock(Router $router) {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $alertas = [];
        $producto = Producto::all();
        $usuarios = Auth::all();

        $id = validarORedireccionar('/stock');   
        $stock = Stock::find($id);

        $inventario = new Inventario;

        $cantTemporal = Inventario::findRegistro($stock->productoId ?? 0);
        $cantAnteriorInventario = intval($cantTemporal->cantidadTotal ?? 0);
        $referenciaAnterior = $cantTemporal->referencia;

        $cantidadAnterior = $stock->cantidad ?? 0;

        $stock->estado = "Activo";
        $inventario->estado = "Activo";     

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $stock->sincronizar($_POST);
            $alertas = $stock->validar();

            $inventario->sincronizar($_POST);            
            $alertas = $inventario->validar();
                  

            // Revisa que alertas esté vacio
            if(empty($alertas) && intval($_POST['cantidad']) <= $cantidadAnterior) {

                $referencia = $referenciaAnterior;
                $movimiento = 'Salida';
                date_default_timezone_set('America/Costa_Rica');
                $fechaActual = date(format:'Y-m-d h:i:s');
                $usuario = $_SESSION['id'];

                $cantidad = intval($cantidadAnterior ?? 0) - intval($_POST['cantidad']);
                $stock->cantidad = $cantidad;

                $stock->movimiento = $movimiento;
                $stock->fechaCreacion = $fechaActual;
                $stock->usuarioId = $usuario;



                /*** INVENTARIOS KARDEX */
                    $cantProducto = $inventario->calculoCantidad('producto', 'id', $inventario->productoId);
                    $cantPorProducto = intval($cantProducto->cantidad); // Cantidad de unidades por producto

                    $inventario->cantidadAnterior = $cantidadAnterior;

                    $inventario->cantidadEntrada = 0;  // Cantidad de Entrada
                    $inventario->cantidadSalida = intval($_POST['cantidad']); // Cantidad de Salida
                                           
                    $inventario->cantidadTotal = $cantidadAnterior - $inventario->cantidadSalida;

                    $inventario->referencia = $referencia;
                    $inventario->operacion = $movimiento;
                    $inventario->fechaCreacion = $fechaActual;
                    $inventario->usuarioId = $usuario;

                    //debug($inventario);

                /*** FIN INVENTARIOS KARDEX */

                $resultado = $stock->actualizar();
                $resultado = $inventario->crear();
                
                if($resultado) {                
                    Stock::setAlerta('info', 'Se han retirado ' . $inventario->cantidadSalida . ' productos del stock');
                }
            } else {
                Stock::setAlerta('error', 'La cantidad en stock no es suficiente para realizar la salida (En stock: ' . $cantidadAnterior . ')');
            }
        }
             

        $alertas = Stock::getAlertas();
        $router->render('stock/salidaStock', [
            'producto' => $producto,
            'stock' => $stock,
            'inventario' => $inventario,
            'usuarios' => $usuarios,
            'alertas' => $alertas
        ]);
    }

    public static function entrada(Router $router) {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $id = validarORedireccionar('/inventario');   
        $inventario = Inventario::find($id);
        $producto = Producto::all();
        $usuarios = Auth::all();


        $alertas = [];


        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $inventario->sincronizar($_POST);
            
            $alertas = $inventario->validar();

            // Revisa que alertas esté vacio
            if(empty($alertas)) {

                $cantInventario = $inventario->calcularCantidad($id, 'inventario', 'id');
                $inventario->cantidadAnterior = intval($cantInventario->cantidadTotal);


                //$inventario->cantidadAnterior = $cantInventarioTemporal;

                $inventario->cantidadSalida = 0;  // Cantidad de Salida
                $inventario->cantidadEntrada = intval($_POST['cantidad']); // Cantidad de Entrada
                

                $inventario->cantidadTotal = $inventario->cantidadAnterior + intval($_POST['cantidad']);



                
                
                //debug(intval($cantInventario->cantidad));

                //$cantidadSalida = intval($_POST['cantidad']);
                
                
                //$inventario->cantidad;
                //debug($inventario->cantidad);
                //debug($inventario->cantidad - intval($_POST['cantidad']));
                
                $inventario->operacion = 'salida';
                $inventario->fechaCreacion = date(format:'Y-m-d H:i:s');
                $inventario->usuarioId = $_SESSION['id'];
                
                // Guarda Categoría
                $resultado = $inventario->crear();

                if($resultado) { // Si se guarda el usuario envia una alerta                       
                    Inventario::setAlerta('exito', 'Se ha actualizado el inventario');                      
                    //header('Location: /categoria');
                }
            }
        }
             

        $alertas = Inventario::getAlertas();
        $router->render('inventario/entrada', [
            'producto' => $producto,
            'inventario' => $inventario,
            'usuarios' => $usuarios,
            'alertas' => $alertas
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

        $stock = new Stock;
        $inventario = new Inventario;

        $stock->estado = "Activo";
        $inventario->estado = "Activo";  

        $resultado = $stock->existeStock($_POST['productoId'] ?? 0);

        if($resultado->num_rows) { // SI EXISTE - SOLO AGREGA LA CANTIDAD
            
            $stock = Stock::findStock($_POST['productoId']); // Busco el id del producto seleccionado
            $cantStockAnterior = $stock->cantidad; // Almaceno la cantidad del produto de la DB

            if ($cantStockAnterior < $_POST['cantidad']) { // Verifica si la cantidad en stock es suficiente
                Stock::setAlerta('error', 'La cantidad en stock no es suficiente para realizar la salida (En stock: ' . $cantStockAnterior . ')');
                //header('Location: /templates/error404');
                //exit; // Detiene la ejecución si la cantidad no es suficiente
            } else{
                $movimiento = 'Salida';
                date_default_timezone_set('America/Costa_Rica');
                $fechaActual = date(format:'Y-m-d H:i:s');
                $usuario = $_SESSION['id'];
    
                $stock->movimiento = $movimiento;
                $stock->fechaCreacion = $fechaActual;
                $stock->usuarioId = $usuario;
                //$stock->estado = $_POST['estado'];
                
    
                //*** INVENTARIOS KARDEX */
    
                $cantTemporal = Inventario::findRegistro($stock->productoId ?? 0);
                $cantAnteriorInventario = intval($cantTemporal->cantidadTotal ?? 0);
                $referenciaAnterior = $cantTemporal->referencia;
    
                $inventario->sincronizar($_POST);
                $alertas = $inventario->validar();
     
    
                $cantProducto = $inventario->calculoCantidad('producto', 'id', $inventario->productoId);
                $cantPorProducto = intval($cantProducto->cantidad); // Cantidad de unidades por producto
    
                $inventario->cantidadAnterior = $cantAnteriorInventario;
    
                $inventario->cantidadEntrada = 0;  // Cantidad de Entrada
                $inventario->cantidadSalida = intval($_POST['cantidad']);; // Cantidad de Salida
    
                $inventario->cantidadTotal = $inventario->cantidadAnterior - $inventario->cantidadSalida;
    
                $inventario->referencia = $referenciaAnterior;
                $inventario->operacion = $movimiento;
                $inventario->fechaCreacion = $fechaActual;
                $inventario->usuarioId = $usuario;
    
                /*** FIN INVENTARIOS KARDEX */
           
                $cantIngresada = intval($_POST['cantidad']); // Almaceno la cantidad que se está ingresando
    
                $cantNueva = (intval($cantStockAnterior) - intval($cantIngresada)); // Se realiza el calculo de la nueva cantidad
                $stock->cantidad = $cantNueva;
    
                $resultado = $inventario->crear();
                $resultado = $stock->actualizar();
            
                if($resultado) {                
                    Stock::setAlerta('info', 'Se han retirado ' . $cantIngresada  . ' productos del stock  (En stock: ' . $cantNueva . ')');
                }
            }    

            

            //exit('EXISTE');

        } else { //NO EXISTE -- NO HACE NADA
            Stock::setAlerta('error', 'El producto seleccionado no se encuentra en stock');
        }

        $alertas = Stock::getAlertas();
        $router->render('stock/nuevaSalida', [
            'producto' => $producto,
            'stock' => $stock,
            'inventario' => $inventario,
            'usuarios' => $usuarios,
            'alertas' => $alertas
        ]);
    }


    public static function eliminar() {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }
        
      if($_SERVER['REQUEST_METHOD'] === 'POST') {
          $id = $_POST['id'];
          debug($id);
          $inventario = Inventario::find($id);
          $inventario->eliminar();
          Inventario::setAlerta('error', 'Se ha eliminado un registro');
          
          header('Location: /inventario');
      }


    }



    public static function salida(Router $router) {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $id = validarORedireccionar('/inventario');   
        $inventario = Inventario::find($id);
        $producto = Producto::all();
        $usuarios = Auth::all();


        $alertas = [];


        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $inventario->sincronizar($_POST);
            
            $alertas = $inventario->validar();

            // Revisa que alertas esté vacio
            if(empty($alertas)) {

                $cantInventario = $inventario->calcularCantidad($id, 'inventario', 'id');
                $inventario->cantidadAnterior = intval($cantInventario->cantidadTotal);


                //$inventario->cantidadAnterior = $cantInventarioTemporal;

                $inventario->cantidadSalida = intval($_POST['cantidad']);  // Cantidad de Salida
                $inventario->cantidadEntrada = 0; // Cantidad de Entrada
                

                $inventario->cantidadTotal = $inventario->cantidadAnterior - intval($_POST['cantidad']);



                
                
                //debug(intval($cantInventario->cantidad));

                //$cantidadSalida = intval($_POST['cantidad']);
                
                
                //$inventario->cantidad;
                //debug($inventario->cantidad);
                //debug($inventario->cantidad - intval($_POST['cantidad']));
                
                $inventario->operacion = 'salida';
                $inventario->fechaCreacion = date(format:'Y-m-d H:i:s');
                $inventario->usuarioId = $_SESSION['id'];
                
                // Guarda Categoría
                $resultado = $inventario->crear();

                if($resultado) { // Si se guarda el usuario envia una alerta                       
                    Stock::setAlerta('exito', 'Se ha actualizado el inventario');                      
                    //header('Location: /categoria');
                }
            }
        }
             

        $alertas = Stock::getAlertas();
        $router->render('inventario/salida', [
            'producto' => $producto,
            'inventario' => $inventario,
            'usuarios' => $usuarios,
            'alertas' => $alertas
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