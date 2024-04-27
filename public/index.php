<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AuthController;
use Controllers\AdminController;

use Controllers\CategoriaController;

use Controllers\ProductoController;

use Controllers\PedidoController;

use Controllers\DashboardController;
use Controllers\Errores;
use Controllers\InventarioController;
use Controllers\MedidaController;
use MVC\Router;
$router = new Router();

/********* USUARIOS ************/

    // Iniciar Sesión
    $router->get('/', [AuthController::class, 'login']);
    $router->post('/auth/login', [AuthController::class, 'login']);
    $router->get('/auth/logout', [AuthController::class, 'logout']);

    // Crear Cuenta
    $router->get('/auth/crear_cuenta', [AuthController::class, 'crear_cuenta']);
    $router->post('/auth/crear_cuenta', [AuthController::class, 'crear_cuenta']);


    // Olvide Contraseña
    $router->get('/auth/olvide_password', [AuthController::class, 'olvide_password']);
    $router->post('/auth/olvide_password', [AuthController::class, 'olvide_password']);

    // Recuperar Contraseña
    $router->get('/auth/cambiar_password', [AuthController::class, 'cambiar_password']);
    $router->post('/auth/cambiar_password', [AuthController::class, 'cambiar_password']);

    // Confirmación de cuenta
    $router->get('/auth/confirmar_cuenta', [AuthController::class, 'confirmar_cuenta']);
    $router->get('/auth/mensaje', [AuthController::class, 'mensaje']);


    // Mostrar Usuarios
    $router->get('/auth/mostrar', [AuthController::class, 'mostrar']);

    // Actualizar Usuarios
    $router->get('/auth/actualizar_cuenta', [AuthController::class, 'actualizar_cuenta']);
    $router->post('/auth/actualizar_cuenta', [AuthController::class, 'actualizar_cuenta']);

    // Eliminar Usuario
    $router->post('/auth/eliminar_cuenta', [AuthController::class, 'eliminar_cuenta']);

    // Desactivar Usuario
    $router->post('/auth/desactivar', [AuthController::class, 'desactivar']);

        // Activar Usuario
        $router->post('/auth/activar', [AuthController::class, 'activar']);
    
/********************************/



/********* DASHBOARD ************/

    // Dashboard
    $router->get('/dashboard', [DashboardController::class, 'mostrar']);
/********************************/



/********* CATEGORÍA ************/

    // Mostrar
    $router->get('/categoria', [CategoriaController::class, 'mostrar']);

    // Crear
    $router->get('/categoria/crear', [CategoriaController::class, 'crear']);
    $router->post('/categoria/crear', [CategoriaController::class, 'crear']);

    // Actualizar
    $router->get('/categoria/actualizar', [CategoriaController::class, 'actualizar']);
    $router->post('/categoria/actualizar', [CategoriaController::class, 'actualizar']);

    // Desactivar 
    $router->post('/categoria/desactivar', [CategoriaController::class, 'desactivar']);

/********************************/



/********* PRODUCTOS ************/
    
    // Productos
    $router->get('/producto', [ProductoController::class, 'mostrar']);

    // Crear
    $router->get('/producto/crear', [ProductoController::class, 'crear']);
    $router->post('/producto/crear', [ProductoController::class, 'crear']);

    // Actualizar
    $router->get('/producto/actualizar', [ProductoController::class, 'actualizar']);
    $router->post('/producto/actualizar', [ProductoController::class, 'actualizar']);

    // Eliminar
    $router->post('/producto/eliminar', [ProductoController::class, 'eliminar']);
/********************************/

/********* PEDIDOS ************/

    // Pedido
    $router->get('/pedido', [PedidoController::class, 'mostrar']);
    $router->get('/pedido/crear', [PedidoController::class, 'crear']);
    $router->post('/pedido/crear', [PedidoController::class, 'crear']);
    
    $router->get('/pedido/carrito', [PedidoController::class, 'carrito']);
    $router->post('/pedido/carrito', [PedidoController::class, 'carrito']);

    $router->get('/pedido/borrarCarrito', [PedidoController::class, 'borrarCarrito']);
    $router->post('/pedido/borrarCarrito', [PedidoController::class, 'borrarCarrito']);

    $router->get('/pedido/guardaPedido', [PedidoController::class, 'guardaPedido']);
    $router->post('/pedido/guardaPedido', [PedidoController::class, 'guardaPedido']);

    $router->get('/pedido/actualizar', [PedidoController::class, 'actualizar']);
    $router->post('/pedido/actualizar', [PedidoController::class, 'actualizar']);

    $router->get('/pedido/gestionaReferencia', [PedidoController::class, 'gestionaReferencia']);
    $router->post('/pedido/gestionaReferencia', [PedidoController::class, 'gestionaReferencia']);

    $router->get('/pedido/actualizaReferencia', [PedidoController::class, 'actualizaReferencia']);
    $router->post('/pedido/actualizaReferencia', [PedidoController::class, 'actualizaReferencia']);
/********************************/

/********* STOCK ************/

    // STOCK
    $router->get('/stock', [InventarioController::class, 'mostrarStock']);
    
    $router->get('/stock/nuevoStock', [InventarioController::class, 'nuevoStock']);
    $router->post('/stock/nuevoStock', [InventarioController::class, 'nuevoStock']);

    $router->get('/stock/entradaStock', [InventarioController::class, 'entradaStock']);
    $router->post('/stock/entradaStock', [InventarioController::class, 'entradaStock']);

    $router->get('/stock/salidaStock', [InventarioController::class, 'salidaStock']);
    $router->post('/stock/salidaStock', [InventarioController::class, 'salidaStock']);

    $router->get('/stock/nuevaSalida', [InventarioController::class, 'nuevaSalida']);
    $router->post('/stock/nuevaSalida', [InventarioController::class, 'nuevaSalida']);

    // $router->post('/stock/eliminar', [InventarioController::class, 'eliminar']);
/********************************/


/********* INVENTARIO ************/

    // Inventario
    $router->get('/inventario', [InventarioController::class, 'mostrar']);
    $router->get('/inventario/entrada', [InventarioController::class, 'entrada']);
    $router->post('/inventario/entrada', [InventarioController::class, 'entrada']);
    $router->get('/inventario/salida', [InventarioController::class, 'salida']);
    $router->post('/inventario/salida', [InventarioController::class, 'salida']);

    $router->post('/inventario/eliminar', [InventarioController::class, 'eliminar']);
/********************************/


/********* MEDIDAS ************/

    // Inventario
    $router->get('/medida', [MedidaController::class, 'mostrar']);
    $router->get('/medida/crear', [MedidaController::class, 'crear']);
    $router->post('/medida/crear', [MedidaController::class, 'crear']);
    $router->get('/medida/actualizar', [MedidaController::class, 'actualizar']);
    $router->post('/medida/actualizar', [MedidaController::class, 'actualizar']);

    $router->post('/medida/eliminar', [MedidaController::class, 'eliminar']);
/********************************/




/********* ADMINISTRADOR ************/

    // ADMINISTRADOR
    $router->get('/admin', [AdminController::class, 'admin']);

    // GESTIÓN DE ARCHIVOS PDF

    $router->get('/fpdf/pdfCategoria', [AdminController::class, 'pdfCategoria']);
    $router->get('/fpdf/pdfProducto', [AdminController::class, 'pdfProducto']);
    $router->get('/fpdf/pdfPedido', [AdminController::class, 'pdfPedido']);
    $router->get('/fpdf/pdfInventario', [AdminController::class, 'pdfInventario']);
    $router->get('/fpdf/pdfUsuario', [AdminController::class, 'pdfUsuario']);
    $router->get('/fpdf/pdfMedidas', [AdminController::class, 'pdfMedidas']);


    // GESTIÓN DE ARCHIVOS EXCEL
    $router->get('/producto/csvProducto', [AdminController::class, 'csvProducto']);
    
/********************************/



/********* RUTAS DE ERRORES ************/

    // ERROR 403
    $router->get('/templates/error403', [Errores::class, 'error403']);

    // ERROR 404
    $router->get('/templates/error404', [Errores::class, 'error404']);


/********************************/

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();