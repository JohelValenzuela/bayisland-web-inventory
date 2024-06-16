<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Auth;
use Model\Categoria;
use Model\DetallePedido;
use Model\MaestroPedido;
use Model\Pedido;
use Model\Producto;
use Model\UnidadMedida;
use MVC\Router;

class PedidoController {

    public static function crear(Router $router) {
        $alertas = [];
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

            $alertas = Pedido::getAlertas();

            
            if (isset($_SESSION['msg'])) {
                $alertas = $_SESSION['msg'];
                unset($_SESSION['msg']); // Limpia la variable de sesión
            }
                

            $router->render('pedido/crear', [
                'producto' => $producto,
                'categoria' => $categoria,
                'medidas' => $medidas,
                'resultado' => $resultado,
                'alertas' => $alertas                
            ]);
            
            
        } else {
            $router->render('pedido/crear', []);
        }

        //unset($_SESSION['msg']); // Limpia la variable de sesión
    }

    public static function mostrar(Router $router) {

        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }

        $alertas = [];

        $user = $_SESSION['id'];

        if ($_SESSION['rol'] == 'Encargado') {
            $maestro = MaestroPedido::allNombre($user);
        } else if($_SESSION['rol'] == 'Administrador') {
            $maestro = MaestroPedido::all();
        }

        if(!empty($maestro)){

            $detalle = DetallePedido::all();
            $categoria = Categoria::all();
            $producto = Producto::all();
            $usuarios = Auth::all();

            // Recorrer los maestros
            foreach ($maestro as $maestros) {
                // Obtener el conteo de productos en el detalle para este maestro
                $cuentaDetalle = DetallePedido::cuentaCantidadEstado('maestroId', $maestros->id);
                // Asignar el conteo al maestro
                $maestros->cantidadProductos = $cuentaDetalle;
                // Obtener los usuarios asociados a este maestro
                $maestros->usuario = Auth::find($maestros->usuarioId);
                $maestros->usuarioAprueba = Auth::find($maestros->usuarioIdAprueba);
            }

            foreach ($detalle as $detalles) {
                $detalles->producto = Producto::find($detalles->productoId);
            }

            $alertas = Pedido::getAlertas();

            
            if (isset($_SESSION['msgPedido'])) {
                $alertas = $_SESSION['msgPedido'];
                unset($_SESSION['msgPedido']); // Limpia la variable de sesión
            }


            $router->render('pedido/mostrar', [
                'maestro' => $maestro,
                'detalle' => $detalle,
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

    public static function carrito(Router $router) {
        
        $alertas = [];

        // Verificar si se ha iniciado una sesión de carrito o se ha enviado un ID de producto
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
                $unidad_empaque = $_POST['unidad_empaque'];
                $cantidadEmpaque = $_POST['cantidadEmpaque'];
                $cantidad = $_POST['cantidad'];
    
                // Verifica si el producto ya está en el carrito
                $indice = array_search($id, array_column($orden, 'id'));
                
    
                if($indice !== false){  
                    // El producto ya está en el carrito, aumenta la cantidad según lo recibido
                    $orden[$indice]["cuantos"] += $cantidad;
                    $_SESSION["carrito"] = $orden; // Actualiza el carrito en la sesión
                    Pedido::setAlerta('exito', 'Se agregaron ' . $cantidad . ' unidades del producto ' . $_POST['nombre'] . ' a la orden de compra.' . ' (' . $orden[$indice]["cuantos"] . ' unidades en total)');
                    $_SESSION['msg'] = Pedido::getAlertas();
                    header("Location: ".$_SERVER["HTTP_REFERER"]."");
                    exit;
                } else {
                    // Agrega el producto al carrito con la cantidad inicial
                    $orden[] = array(
                        "id" => $id,
                        "categoriaId" => $categoriaId,
                        "nombre" => $nombre,
                        "presentacion" => $presentacion,
                        "cantidadPresentacion" => $cantidadPresentacion,
                        "medidaId" => $medidaId,
                        "unidad_empaque" => $unidad_empaque,
                        "cantidad" => $cantidadEmpaque,
                        "cuantos" => $cantidad  // Inicia con la cantidad recibida
                    );
                    
                }
    
                // Establece un mensaje de éxito y redirige
                Pedido::setAlerta('exito', 'Se agregaron ' . $cantidad . ' unidades del producto ' . $_POST['nombre'] . ' a la orden de compra');
                $_SESSION['msg'] = Pedido::getAlertas();
               
                
            }
    
            // Actualiza el carrito en la sesión
            $_SESSION["carrito"] = $orden;
            
        }

        header("Location: ".$_SERVER["HTTP_REFERER"]."");

        $alertas = Pedido::getAlertas();
        // Renderiza la vista de carrito con las alertas
        $router->render('pedido/carrito', [
            'alertas' => $alertas
        ]);
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
    
                Pedido::setAlerta('exito', 'Se ha actualizado la cantidad del producto '. $orden[$id]["nombre"] .' en el carrito');
                $_SESSION['msg'] = Pedido::getAlertas();
                header("Location: ".$_SERVER["HTTP_REFERER"]."");

            } else {
                Pedido::setAlerta('error', 'El producto no existe en el carrito');
                $_SESSION['msg'] = Pedido::getAlertas();
                header("Location: ".$_SERVER["HTTP_REFERER"]."");
            }
        } else {
            Pedido::setAlerta('error', 'No hay productos en el carrito');
            $_SESSION['msg'] = Pedido::getAlertas();
            header("Location: ".$_SERVER["HTTP_REFERER"]."");
        }
    }

    public static function eliminarProductoCarrito() {
        if(isset($_POST['id'])) {
            $id = $_POST['id'];
            
            // Llama a la función para eliminar el producto del carrito
            if(isset($_SESSION["carrito"])) {
                $orden = $_SESSION["carrito"];

                Pedido::setAlerta('info', 'Se ha eliminado ' . $orden[$id]["nombre"] . ' de la orden de compra');
                $_SESSION['msg'] = Pedido::getAlertas();
        
                // Verifica si el ID del producto existe en el carrito
                if(array_key_exists($id, $orden)) {
                    // Elimina el producto del carrito usando unset()
                    unset($orden[$id]);     
        
                    // Actualiza la sesión del carrito
                    $_SESSION["carrito"] = $orden;
                }
            }
            header("Location: ".$_SERVER["HTTP_REFERER"]."");
            // Redirige de vuelta a la página anterior
            //header("Location: crear#openModal"); 
            exit;
        }
    }
    
    public static function borrarCarrito(){
        Pedido::setAlerta('info', 'Se ha eliminado la orden de compra');
        $_SESSION['msg'] = Pedido::getAlertas();
        header("Location: ".$_SERVER["HTTP_REFERER"]."");
        unset($_SESSION["carrito"]);
    }

    
    public static function guardaPedido(Router $router) {
        $alertas = [];
        $pedido = new Pedido;
        $maestro = new MaestroPedido;
        $detalle = new DetallePedido;
    
        $referencia = uniqid();      
    
        // Asigna los valores al maestro del pedido
        $maestro->referencia = $referencia;
        date_default_timezone_set('America/Costa_Rica');
        $maestro->usuarioId = intval($_SESSION['id']);  
        $maestro->usuarioIdAprueba = 0;  
        $maestro->fechaCreacion = date('Y-m-d H:i:s');
        $maestro->estado = 'Pendiente';
    
        // Crea el maestro del pedido en la base de datos
        $resultado = $maestro->crear();
        $idmaestro = $resultado['id'];
    
        // Obtiene el carrito de la sesión
        if(isset($_SESSION["carrito"])){
            $orden = $_SESSION["carrito"];
        }
    
        // Recorre el carrito para guardar cada detalle del pedido
        if(isset($_SESSION["carrito"])){
            for($i=0; $i<count($orden); $i++) {
                // Crea un nuevo detalle del pedido con los datos del carrito
                $detalle->maestroId = $idmaestro;
                $detalle->productoId = intval($orden[$i]["id"]);
                $detalle->cantidad = intval($orden[$i]["cuantos"]);
                $detalle->observacion = 'Pedido #' . $referencia;
    
                // Guarda el detalle del pedido en la base de datos
                $resultado = $detalle->crear();
    
                if($resultado) {
                    Pedido::setAlerta('exito', 'Pedido enviado correctamente');
                }
            }
        }
    
        // Limpia el carrito de la sesión después de guardar el pedido
        unset($_SESSION["carrito"]);
    
        // Redirige a la página de pedidos con las alertas
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
        $detalle = DetallePedido::find($id);

        $categoria = Categoria::all();
        $producto = Producto::all();
        $usuarios = Auth::all();

        $detalle->producto = Producto::find($detalle->productoId); // Obtener detalles del producto por el id
        $detalle->medida = UnidadMedida::find($detalle->producto->medidaId); // Obtener los detalles de la unidad de medida, mediante el id del producto
        //debug($detalle->medida->nombre);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $detalle->sincronizar($_POST);
            
            $alertas = $detalle->validar();

            if(empty($alertas)){
                
                // Se llama la funcion para guardar en la DB
                $resultado = $detalle->guardar();
                
                if($resultado) { // Si se guarda el usuario envia una alerta
                    DetallePedido::setAlerta('exito', 'Se ha actualizado el producto');
                    //header('Location: /producto');
                }
            }
        }

        
        $alertas = DetallePedido::getAlertas();
        $router->render('pedido/actualizar', [
            'detalle' => $detalle,
            'categoria' => $categoria,
            'producto' => $producto,
            'usuarios' => $usuarios,
            'alertas' => $alertas
        ]);

    }

    public static function gestionaReferencia(Router $router){

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $alertas = [];

        $id = validarORedireccionar('/pedido'); 
        $maestro = MaestroPedido::findMaestro($id);

        $aprobado = $_SESSION['id'];
        $maestro->usuarioIdAprueba = $aprobado;

        $detalle = DetallePedido::all();
        $categoria = Categoria::all();
        $producto = Producto::all();
        $usuarios = Auth::all();

        $cuentaDetalle = DetallePedido::cuentaCantidadEstado('maestroId', $id); // Cuenta cuantos productos tiene en detalle el maestro




        $maestro->usuario = Auth::find(intval($maestro->usuarioId));
        $maestro->usuarioAprueba = Auth::find($maestro->usuarioIdAprueba);

        

        foreach ($detalle as $detalles) {
            $detalles->producto = Producto::find($detalles->productoId);
        }



        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $maestro->sincronizar($_POST);

            $alertas = $maestro->validar();

            if(empty($alertas)){
                
                // Se llama la funcion para guardar en la DB
                $resultado = $maestro->actualizar();

                //debug($resultado);
                
                if($resultado) { // Si se guarda el usuario envia una alerta
                    MaestroPedido::setAlerta('exito', 'Se ha actualizado el producto');
                    //header('Location: /producto');
                }
            }
        }

        $alertas = MaestroPedido::getAlertas();

        $router->render('pedido/gestionaReferencia', [
            'cuentaDetalle' => $cuentaDetalle,
            'detalle' => $detalle,
            'maestro' => $maestro,
            'categoria' => $categoria,
            'producto' => $producto,
            'usuarios' => $usuarios,
            'alertas' => $alertas
        ]);

    }

  
    public static function eliminar(){
        
        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        if($_SESSION['rol'] === 'Administrador') {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'];
                $detalle = DetallePedido::find($id);

                $detalle->producto = Producto::find($detalle->productoId);
                $detalle->referencia = MaestroPedido::find($detalle->maestroId);

                Pedido::setAlerta('info', '['.$detalle->referencia->id.'] ' . $detalle->producto->nombre .' ha sido eliminado del pedido ' . $detalle->referencia->referencia);
                $_SESSION['msgPedido'] = Pedido::getAlertas();

                $detalle->eliminar();

                header('Location: /pedido');
            }
        } else {
            header('Location: /templates/error403');
        }

        
    }

}
