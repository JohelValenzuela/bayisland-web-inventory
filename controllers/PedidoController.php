<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Auth;
use Model\Categoria;
use Model\Pedido;
use Model\Producto;
use Model\UnidadMedida;
use MVC\Router;

class PedidoController {

    public static function crear(Router $router) {

        $producto = Producto::all();
        if(!empty($producto)){

            
            $producto=Producto::all();
    
            $categoria = Categoria::all();
            $medidas = UnidadMedida::all();

            foreach ($producto as $productos) {
                $productos->categoria = Categoria::find($productos->categoriaId);
                $productos->medida = UnidadMedida::find($productos->medidaId);
            }

            // muestra mensaje condicional
            $resultado = $_GET['resultado'] ?? null; //le asigna el valor null en caso de que no esté resultado

            

            $router->render('pedido/crear', [
                'producto' => $producto,
                'categoria' => $categoria,
                'medidas' => $medidas,
                'resultado' => $resultado
            ]);
        } else {
            $router->render('pedido/crear', []);
        }
    }

    public static function mostrar(Router $router) {

        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }

        $alertas = [];

        $pedido = Pedido::all();
        if(!empty($pedido)){

            $pedido = Pedido::all();
            $categoria = Categoria::all();
            $producto = Producto::all();
            $usuarios = Auth::all();

            foreach ($pedido as $pedidos) {
                $pedidos->categoria = Categoria::find($pedidos->categoriaId);
                $pedidos->producto = Producto::find($pedidos->productoId);
                $pedidos->usuario = Auth::find($pedidos->usuarioId);
                //debug($usuarios);
            }

            $router->render('pedido/mostrar', [
                'pedido' => $pedido,
                'categoria' => $categoria,
                'producto' => $producto,
                'usuarios' => $usuarios,
                'alertas' => $alertas
            ]);
        } else {
            $router->render('pedido/mostrar', [
                'alertas' => $alertas
            ]);
        }
    }

    public static function carrito() {
        // Verifica si se ha iniciado una sesión de carrito o se ha enviado un ID de producto
        if(isset($_SESSION["carrito"]) || isset($_POST['id'])) {
            // Inicializa la variable $orden
            $orden = [];
    
            // Si existe una sesión de carrito, asigna su valor a la variable $orden
            if(isset($_SESSION["carrito"])){
                $orden = $_SESSION["carrito"];
            }
    
            // Si se ha enviado un ID de producto, agrega el producto al carrito
            if(isset($_POST['id'])) {  
                $id = $_POST['id'];
                $categoriaId = $_POST['categoriaId'];
                $nombre = $_POST['nombre'];
                $presentacion = $_POST['presentacion']; 
                $cantidadPresentacion = $_POST['cantidadPresentacion'];
                $medidaId = $_POST['medidaId']; 
                $unidad_empaque =  $_POST['unidad_empaque'];
                $cantidad = $_POST['cantidad']; 
    
                // Verifica si el producto ya está en el carrito
                $indice = array_search($id, array_column($orden, 'id'));
    
                if($indice !== false){  // El producto ya está en el carrito, aumenta la cantidad
                    $orden[$indice]["cuantos"] += 1;
                } else {
                    // Agrega el producto al carrito
                    $orden[] = array(
                        "id" => $id,
                        "categoriaId" => $categoriaId,
                        "nombre" => $nombre,
                        "presentacion" => $presentacion,
                        "cantidadPresentacion" => $cantidadPresentacion,
                        "medidaId" => $medidaId,
                        "unidad_empaque" => $unidad_empaque,
                        "cantidad" => $cantidad,
                        "cuantos" => 1
                    );
                }
    
                // Establece un mensaje de éxito y redirige
                Pedido::setAlerta('exito', 'Se ha agregado un producto a la orden de compra');
                header("Location: ".$_SERVER["HTTP_REFERER"]."");
            }
    
            // Actualiza el carrito en la sesión
            $_SESSION["carrito"] = $orden;
        }
    }

    public static function editarCarrito(){
        if(isset($_POST["id"]) && isset($_POST["cantidad"])){
            $id = $_POST["id"];
            $cantidad = $_POST["cantidad"];
    
            // Llama a la función editarCarrito con los datos obtenidos de $_POST
            self::editarCarritoFuncion($id, $cantidad);
        } else {
            // Maneja el caso en que no se proporcionen los datos esperados
            echo "Error: No se proporcionaron datos válidos.";
        }
    }
    
    // Función para editar el carrito, toma los argumentos directamente
    private static function editarCarritoFuncion($id, $cantidad){
        // Lógica para editar el carrito
        if(isset($_SESSION["carrito"])){
            $orden = $_SESSION["carrito"];
    
            // Verificar si el ID del producto existe en el carrito
            if(array_key_exists($id, $orden)){
                // Actualizar la cantidad del producto en el carrito
                $orden[$id]["cuantos"] = $cantidad;
    
                // Actualizar la sesión del carrito
                $_SESSION["carrito"] = $orden;
    
                Pedido::setAlerta('exito', 'Se ha actualizado la cantidad del producto en el carrito');
                header("Location: crear#openModal"); 
            } else {
                Pedido::setAlerta('error', 'El producto no existe en el carrito');
                header("Location: ".$_SERVER["HTTP_REFERER"]."");
            }
        } else {
            Pedido::setAlerta('error', 'No hay productos en el carrito');
            header("Location: ".$_SERVER["HTTP_REFERER"]."");
        }
    }

    public static function eliminarProductoCarrito() {
        if(isset($_POST['id'])) {
            $id = $_POST['id'];
            
            // Llama a la función para eliminar el producto del carrito
            if(isset($_SESSION["carrito"])) {
                $orden = $_SESSION["carrito"];
        
                // Verifica si el ID del producto existe en el carrito
                if(array_key_exists($id, $orden)) {
                    // Elimina el producto del carrito usando unset()
                    unset($orden[$id]);     
        
                    // Actualiza la sesión del carrito
                    $_SESSION["carrito"] = $orden;
                }
            }
    
            // Redirige de vuelta a la página anterior
            header("Location: crear#openModal"); 
            exit;
        }
    }
    
    
    
    
    public static function borrarCarrito(){
        Pedido::setAlerta('exito', 'Se ha borrado la orden de compra');
        header("Location: ".$_SERVER["HTTP_REFERER"]."");
        unset($_SESSION["carrito"]);
    }

    public static function guardaPedido(Router $router){

        $alertas = [];
        $pedido = new Pedido;


        $pedido->referencia = uniqid();
        $pedido->observacion = 'Pedido #' . $pedido->referencia ;
        date_default_timezone_set('America/Costa_Rica');
        $pedido->fechaCreacion = date(format:'Y-m-d H:i:s');
        $pedido->usuarioId = intval($_SESSION['id']);


        if(isset($_SESSION["carrito"])){
            $orden = $_SESSION["carrito"];
            
        }

        if(isset($_SESSION["carrito"])){
            $lleno = 'lleno';
            for($i=0;$i<=count($orden)-1;$i ++){
                        
                
                
                if(isset($orden[$i])){
                    if($orden[$i] != NULL){     

                    
                        // $pedido->cuantos = $orden[$i+1]["cuantos"];
                        // $pedido->id = $orden[$i]["id"];
                        // $pedido->categoriaId = $orden[$i]["categoriaId"];
                        // $pedido->nombre = $orden[$i]["nombre"];
                        // $pedido->presentacion = $orden[$i]["presentacion"]; 
                        // $pedido->cantidadPresentacion = $orden[$i]["cantidadPresentacion"]; 
                        // $pedido->medidaId = $orden[$i]["medidaId"]; 
                        // $pedido->unidad_empaque = $orden[$i]["unidad_empaque"]; 
                        // $pedido->cantidad = $orden[$i]["cantidad"];

                        
                        $pedido->categoriaId = intval($orden[$i]["categoriaId"]);
                        $pedido->productoId = intval($orden[$i]["id"]);
                        $pedido->cantidad = intval($orden[$i]["cuantos"]);
                        
                        if($pedido->cantidad <= 0){
                            $pedido->cantidad = intval($orden[$i]["cuantos"]) + 1;
                        }
                        
                        $resultado = $pedido->crear();
                        Pedido::setAlerta('exito', 'Pedido enviado correctamente');
        }}}
                    unset($_SESSION["carrito"]);
                    
        }
        header("Location: /pedido"); 
        $alertas = Pedido::getAlertas();
        
        $router->render('pedido/mostrar', [
            'alertas' => $alertas,
        ]);
    }

    public static function actualizar(Router $router){

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $alertas = [];

        $id = validarORedireccionar('/pedido'); 
        $pedido = Pedido::find($id);
        

        $categoria = Categoria::all();
        $producto = Producto::all();
        $usuarios = Auth::all();

        //debug(Categoria::find($pedido->categoriaId));

        foreach ($pedido as $pedidos) {
            $pedido->categoria = Categoria::find($pedido->categoriaId);
            $pedido->producto = Producto::find($pedido->productoId);
            $pedido->usuario = Auth::find($pedido->usuarioId);
            $pedido->medida = UnidadMedida::find($pedido->producto->medidaId);
        }

        

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $pedido->sincronizar($_POST);

            //debug($_POST);
            
            $alertas = $pedido->validar();

            
            if(empty($alertas)){
                
                // Se llama la funcion para guardar en la DB
            $resultado = $pedido->guardar();
                
                if($resultado) { // Si se guarda el usuario envia una alerta
                    Pedido::setAlerta('exito', 'Se ha actualizado el producto');
                    //header('Location: /producto');
                }
            }
        }

        
        $alertas = Pedido::getAlertas();
        $router->render('pedido/actualizar', [
            'pedido' => $pedido,
            'categoria' => $categoria,
            'producto' => $producto,
            'usuarios' => $usuarios,
            'alertas' => $alertas
        ]);

    }

    public static function gestionaReferencia(Router $router){
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }

        $alertas = [];
        $referenciaBuscada = $_POST["referencia"] ?? $_GET['referencia'];

        $pedido = new Pedido;

        // Verifica que la referencia exista
        $resultado = $pedido->existeReferencia($referenciaBuscada);

        //debug($resultado);

        if($resultado->num_rows) { // EXISTE         

            if($referenciaBuscada == ""){
                Pedido::setAlerta('error', 'Escribe una referencia válida');
                $alertas = Pedido::getAlertas();
                $router->render('pedido/mostrar', [
                    'alertas' => $alertas
                ]);
            } else{
                $pedido = Pedido::findReferencia($referenciaBuscada);        
                $categoria = Categoria::all();
                $producto = Producto::all();
                $usuarios = Auth::all();
            
                foreach ($pedido as $pedidos) {
                    $pedidos->categoria = Categoria::find($pedidos->categoriaId);
                    $pedidos->producto = Producto::find($pedidos->productoId);
                    $pedidos->usuario = Auth::find($pedidos->usuarioId);
                    $pedidos->medida = UnidadMedida::find($pedidos->producto->medidaId);
                }

                if(empty($_POST['estado'])){
                    Pedido::setAlerta('error', 'Selecciona un estado para el pedido');
                } else if(empty($referenciaBuscada)){
                    Pedido::setAlerta('error', 'No se encontró la referencia');
                }
    
                if(!empty($_POST['estado']) AND !empty($referenciaBuscada)){
                    Pedido::findReferenciaGuarda($_POST['estado'], $_POST['observacion'], $referenciaBuscada);
                    Pedido::setAlerta('exito', 'Pedido Actualizado');
                }
        
                $alertas = Pedido::getAlertas();
                $router->render('pedido/gestionaReferencia', [
                    'pedido' => $pedido,
                    'categoria' => $categoria,
                    'producto' => $producto,
                    'usuarios' => $usuarios,
                    'alertas' => $alertas
                ]);
            }
        } else { //NO EXISTE
            $alertas = Pedido::getAlertas();
            $router->render('pedido/mostrar', [
                'alertas' => $alertas
            ]);
        }


        

        
    }

//     public static function actualizaReferencia(Router $router){
//     isAuth();
//     if(!tieneRol()) {
//         header('Location: /templates/error403');
//     }

//     $alertas = [];
//     $referenciaBuscada = $_POST["referencia"];

//     Pedido::findReferenciaGuarda($_POST['estado'], $_POST['observacion'], $referenciaBuscada);
//     Pedido::setAlerta('exito', 'Se ha actualizado el producto');

//         $alertas = Pedido::getAlertas();
//         $router->render('pedido/mostrar', [
//             'alertas' => $alertas
//         ]);

//         header('Location: /pedido');
// }

}
