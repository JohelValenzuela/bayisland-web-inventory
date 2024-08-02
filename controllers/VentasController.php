<?php

namespace Controllers;

use Model\Auth;
use Model\Bodegas;
use Model\Cliente;
use Model\Cobro;
use Model\Producto;
use Model\Receta;
use Model\Venta;
use Model\VentaProductos;
use Model\IngredientesReceta;
use Model\Inventario;
use Model\RecetaIngredientes;
use Model\Stock;
use MVC\Router;

class VentasController {

    public static function mostrar(Router $router) {

        
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }

        $user = $_SESSION['id'];

        if ($_SESSION['rol'] == 'Encargado') {
            $venta = Venta::all();
        } else if($_SESSION['rol'] == 'Administrador') {
            $venta = Venta::all();
        }

       
        $clientes = Cliente::all();
        $usuarios = Auth::all();
        $ventaProducto = VentaProductos::all();
        $cobros = Cobro::all();
       
        foreach ($ventaProducto as $ventaProductos) {
            $ventaProductos->producto = Producto::find($ventaProductos->producto_id);
            $ventaProductos->receta = Receta::find($ventaProductos->receta_id);
            $ventaProductos->venta = Venta::find($ventaProductos->receta_id);
        }

        foreach ($venta as $ventas) {
            $ventas->cliente = Cliente::find($ventas->cliente);
            $ventas->usuario = Auth::find($ventas->usuario_id);
        }

        $resultado = $_GET['resultado'] ?? null;
        
        $router->render('ventas/mostrar', [
            'venta' => $venta,
            'clientes' => $clientes,
            'ventaProducto' => $ventaProducto,
            'resultado' => $resultado,
            'cobros' => $cobros,
            'usuarios' => $usuarios
        ]);
    }

    public static function carrito(Router $router) {
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
    
        $alertas = [];
        $productos = Producto::all();
        $recetas = Receta::all();
        $usuario = Auth::all();
        $carrito = $_SESSION["carritoVentas"] ?? [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente_id = $_POST['cliente_id'];
            $nuevo_cliente = trim($_POST['nuevo_cliente']);
            $productoOrReceta = $_POST['productoOrReceta'];
            $cantidad = intval($_POST['cantidad']);
            $precio = floatval($_POST['precio']);
            $metodoPago = $_POST['metodoPago'];
            $codigo_brazalete = $_POST['codigo_brazalete'];
    
            

            if (!empty($nuevo_cliente)) {
                $clienteExistente = Cliente::where('nombre', $nuevo_cliente);  
                if ($clienteExistente) {
                    $cliente_id = $clienteExistente->id;
                } else {
                    $cliente = new Cliente(['nombre' => $nuevo_cliente, 'codigo_brazalete' => $codigo_brazalete]);
                    $resultado = $cliente->guardar();
                    $cliente_id = $resultado['id'];
                }
            }
    
            if (!empty($productoOrReceta)) {
                list($tipo, $id) = explode('-', $productoOrReceta);
                if ($tipo === 'producto') {
                    $producto = Producto::find($id);
                    if ($producto) {
                        $carrito[] = [
                            'cliente_id' => $cliente_id,
                            'productoId' => $id,
                            'recetaId' => null,
                            'nombre' => $producto->nombre,
                            'cantidad' => $cantidad,
                            'precio' => $precio,
                            'metodoPago' => $metodoPago,
                            'codigo_brazalete' => $codigo_brazalete
                        ];
                    }
    
                    Venta::setAlerta('exito', 'x' . $cantidad . ' ' . $producto->nombre . ' - Agregado al carrito');
                    $_SESSION['msg'] = Venta::getAlertas();
    
                } elseif ($tipo === 'receta') {
                    $receta = Receta::find($id);
                    if ($receta) {
                        $carrito[] = [
                            'cliente_id' => $cliente_id,
                            'productoId' => null,
                            'recetaId' => $id,
                            'nombre' => $receta->nombre,
                            'cantidad' => $cantidad,
                            'precio' => $precio,
                            'metodoPago' => $metodoPago,
                            'codigo_brazalete' => $codigo_brazalete
                        ];
                    }
    
                    Venta::setAlerta('exito', 'x' . $cantidad . ' ' . $receta->nombre . ' - Agregado al carrito');
                    $_SESSION['msg'] = Venta::getAlertas();
                }
            }
    
            $_SESSION['carritoVentas'] = $carrito;
            header('Location: /ventas/carrito');
            exit;
        }
    
        
        $alertas = Venta::getAlertas();

        if (isset($_SESSION['msg'])) {
            $alertas = $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
    
        $router->render('ventas/carrito', [
            'productos' => $productos,
            'recetas' => $recetas,
            'carrito' => $carrito,
            'alertas' => $alertas,
            'usuario' => $usuario,
        ]);
    }
    
    public static function eliminarProductoCarrito() {
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productoIndex = $_POST['productoIndex'];

            // Obtener el carrito de la sesión
            $carrito = $_SESSION["carritoVentas"] ?? [];
            
            $productoEliminado = $carrito[$productoIndex]['nombre'];
            $cantidadEliminada = $carrito[$productoIndex]['cantidad'];
    
            // Eliminar el producto del carrito según el índice
            if (isset($carrito[$productoIndex])) {
                unset($carrito[$productoIndex]);
                $_SESSION["carritoVentas"] = $carrito;
                Venta::setAlerta('info', $productoEliminado . ' (' . $cantidadEliminada . ') ha sido eliminado de la venta');
                $_SESSION['msg'] = Venta::getAlertas();
            } else {
                Venta::setAlerta('error', 'No se encontró el producto en el carrito de ventas');
                $_SESSION['msg'] = Venta::getAlertas();
            }
    
            // Redirigir de vuelta al carrito
            header("Location: /ventas/carrito");
            exit;
        }
    }

    public static function vaciarCarritoVentas() {
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            unset($_SESSION["carritoVentas"]);
            Venta::setAlerta('exito', 'Carrito de ventas vaciado');
            $_SESSION['msg'] = Venta::getAlertas();
            header("Location: /ventas/carrito");
            exit;
        }
    }

    public static function realizarVenta(Router $router) {
        isAuth();
        if (!tieneRol()) {
            header('Location: /templates/error403');
            exit;
        }
    
        // Obtener los datos del carrito de ventas de la sesión
        $carrito = $_SESSION["carritoVentas"] ?? [];
    
        // Verificar si el carrito está vacío
        if (empty($carrito)) {
            Venta::setAlerta('error', 'El carrito está vacío');
            $_SESSION['msg'] = Venta::getAlertas();
            header('Location: /ventas/carrito');
            exit;
        }
    
        $usuario_id = $_SESSION['id']; // Default to current user
    
        // Si el rol es 'Usuario Fijo', tomar el usuario_id del select
        if ($_SESSION['rol'] == 'Encargado' && isset($_POST['vendedor_id'])) {
            $usuario_id = intval($_POST['vendedor_id']);
        }
    
        // Recorrer el carrito de ventas y guardar cada producto en la tabla venta_productos
        foreach ($carrito as $item) {
            // Obtener el ID del cliente del ítem actual del carrito
            $cliente_id = intval($item['cliente_id']);
            // Buscar ventas existentes para el cliente
            $ventasCliente = Venta::findCliente($cliente_id);
    
            $ventaId = null; // Variable para almacenar el ID de la venta
    
            // Iterar sobre las ventas del cliente
            foreach ($ventasCliente as $ventaCliente) {
                // Verificar si existe un cobro para esta venta
                $cobroExistente = Cobro::findVenta(intval($ventaCliente->id));
    
                // Si no hay un cobro existente y el usuario de la venta coincide con el usuario actual, usar esta venta
                if (!$cobroExistente && $ventaCliente->usuario_id == $usuario_id) {
                    $ventaId = intval($ventaCliente->id);
                    break; // Salir del bucle una vez que se encuentra una venta sin cobro vinculado y con el usuario coincidente
                }
            }
    
            // Si no se encontró una venta sin cobro vinculado y con el usuario coincidente, crear una nueva venta
            if (!$ventaId) {
                $venta = new Venta;
                $venta->cliente = $cliente_id;
                date_default_timezone_set('America/Costa_Rica');
                $venta->fecha = date('Y-m-d H:i:s');
                $venta->usuario_id = $usuario_id; 
                $resultado = $venta->guardar(); // Llama a la función 'guardar' que has proporcionado
                $ventaId = $resultado['id']; // Almacena el ID de la nueva venta
            }
    
            // Guardar el producto en ventaProductos usando el ID de la venta
            $ventaProducto = new VentaProductos;
            $ventaProducto->venta_id = $ventaId;
            $ventaProducto->producto_id = !empty($item['productoId']) ? intval($item['productoId']) : 0;
            $ventaProducto->receta_id = !empty($item['recetaId']) ? intval($item['recetaId']) : 0;
            $ventaProducto->cantidad = $item['cantidad'];
            $ventaProducto->precio = $item['precio'] * $item['cantidad'];
            $ventaProducto->metodoPago = $item['metodoPago'];
            $ventaProducto->codigo_brazalete = $item['codigo_brazalete'];
            $ventaProducto->guardar();
    
            // Si receta_id es diferente a 0, iterar sobre los ingredientes y actualizar el stock
            if ($ventaProducto->receta_id != 0) {
                $ingredientes = RecetaIngredientes::findReceta($ventaProducto->receta_id);
    
                // Verificar que se obtuvieron ingredientes válidos
                if (!$ingredientes) {
                    Venta::setAlerta('error', 'No se encontraron ingredientes para la receta');
                    continue;
                }
    
                foreach ($ingredientes as $ingrediente) {
                    if (empty($ingrediente->productoId)) {
                        Venta::setAlerta('error', 'El ingrediente no tiene un producto válido');
                        continue;
                    }
    
                    $bodegaBote1 = 2;
                    $productoStock = Stock::findStockBodega($ingrediente->productoId, $bodegaBote1);
                    
                    // Verificar que se encontró el stock para el producto
                    if ($productoStock) {
                        $nuevaCantidad = $productoStock->cantidad - ($ventaProducto->cantidad * $ingrediente->cantidad);
                        $productoStock->cantidad = $nuevaCantidad;
                        $productoStock->guardar();
                        
                        $ultimaEntrada = Inventario::findStockBodega($productoStock->productoId, $bodegaBote1);
                        $referenciaAnterior = $ultimaEntrada ? $ultimaEntrada->referencia : '';
                        
                        $kardex = new Inventario();
                        $kardex->referencia = $referenciaAnterior;
                        $kardex->productoId = $productoStock->productoId;
                        $kardex->cantidadAnterior = $ultimaEntrada ? $ultimaEntrada->cantidadTotal : 0;
                        $kardex->operacion = 'Venta' . ' ' . Bodegas::find($bodegaBote1)->nombre;
                        $kardex->cantidadEntrada = 0;
                        $kardex->cantidadSalida = $ingrediente->cantidad * $ventaProducto->cantidad;
                        $kardex->cantidadTotal = $kardex->cantidadAnterior - $kardex->cantidadSalida;
                        $kardex->estado = 'Activo';
                        $kardex->usuarioId = $_SESSION['id'];
                        $kardex->fechaCreacion = date('Y-m-d H:i:s');
                        $kardex->bodegaId = $bodegaBote1;
                        $kardex->guardar();
                    } else {
                        // Manejar el caso en que el producto no se encuentra en el stock
                        Venta::setAlerta('error', 'No se encontró stock para el producto ' . $ingrediente->productoId);
                    }
                }
            } else {
                $bodegaBote1 = 2;
                $productoStock = Stock::findStockBodega($ventaProducto->producto_id, $bodegaBote1);
                
                // Verificar que se encontró el stock para el producto
                if ($productoStock) {
                    $nuevaCantidad = $productoStock->cantidad - ($ventaProducto->cantidad);
                    $productoStock->cantidad = $nuevaCantidad;
                    $productoStock->guardar();
                    
                    $ultimaEntrada = Inventario::findStockBodega($productoStock->productoId, $bodegaBote1);
                    $referenciaAnterior = $ultimaEntrada ? $ultimaEntrada->referencia : '';
                    
                    $kardex = new Inventario();
                    $kardex->referencia = $referenciaAnterior;
                    $kardex->productoId = $productoStock->productoId;
                    $kardex->cantidadAnterior = $ultimaEntrada ? $ultimaEntrada->cantidadTotal : 0;
                    $kardex->operacion = 'Venta' . ' ' . Bodegas::find($bodegaBote1)->nombre;
                    $kardex->cantidadEntrada = 0;
                    $kardex->cantidadSalida = $ventaProducto->cantidad;
                    $kardex->cantidadTotal = $kardex->cantidadAnterior - $kardex->cantidadSalida;
                    $kardex->estado = 'Activo';
                    $kardex->usuarioId = $_SESSION['id'];
                    $kardex->fechaCreacion = date('Y-m-d H:i:s');
                    $kardex->bodegaId = $bodegaBote1;
                    $kardex->guardar();
                } else {
                    // Manejar el caso en que el producto no se encuentra en el stock
                    Venta::setAlerta('error', 'No se encontró stock para el producto ' . $ventaProducto->producto_id);
                }
            }
        }
    
        // Limpiar el carrito de ventas de la sesión
        unset($_SESSION["carritoVentas"]);
    
        // Mostrar mensaje de éxito y redirigir a la página de carrito
        Venta::setAlerta('exito', 'Se ha creado la venta');
        $_SESSION['msg'] = Venta::getAlertas();
        header('Location: /ventas/carrito');
        exit;
    }
    

    
}
