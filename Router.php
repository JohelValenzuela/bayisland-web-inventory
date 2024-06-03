<?php

namespace MVC;

class Router
{


    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {
        // Proteger Rutas...
        session_start();

        // Arreglo de rutas protegidas...
        $rutas_protegidas = ['/admin', '/auth/confirmar_cuenta', '/auth/crear_cuenta', '/auth/mensaje', '/dashboard', '/categoria',
        '/categoria/crear', '/producto', '/producto/crear', '/producto/actualizar', '/producto/eliminar', '/pedido', '/pedido/crear',
        '/inventario', '/inventario/entrada', '/inventario/salida', '/medida', '/medida/crear', '/medida/actualizar'];

        $auth = $_SESSION['login'] ?? null;

        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        // PROTEGER LAS RUTAS
        if(in_array($currentUrl, $rutas_protegidas) && !$auth) {
            header ('Location: /');
        }

        if ($fn ) {
            // Call user fn va a llamar una función cuando no sabemos cual sera
            call_user_func($fn, $this); // This es para pasar argumentos
        } else {
            //header ('Location: /templates/error404');

        }
    }

    public function render($view, $datos = []){
        // Leer lo que le pasamos  a la vista
        foreach ($datos as $key => $value) {
            $$key = $value;  // Doble signo de dolar significa: variable variable, básicamente nuestra variable sigue siendo la original, pero al asignarla a otra no la reescribe, mantiene su valor, de esta forma el nombre de la variable se asigna dinamicamente
        }

        ob_start(); // Almacenamiento en memoria durante un momento...

        // entonces incluimos la vista en el layout
        include_once __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean(); // Limpia el Buffer

        // Utiliza el layout según la URL
        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';

        // Arreglo de rutas Login Layout
        $rutas_login = [ 
            '/', 
            '/auth/login', 
            '/auth/olvide_password', 
            '/auth/cambiar_password', 
            '/templates/error403', 
            '/templates/error404'
        ];

        // Arreglo de rutas Administrador
        $rutas_admin = [ 
            '/dashboard',
            '/categoria',
            '/categoria/crear',
            '/categoria/actualizar',
            '/categoria/formulario',
            '/producto',
            '/producto/crear',
            '/producto/actualizar',
            '/producto/formulario',
            '/pedido',
            '/pedido/crear',
            '/pedido/actualizar',
            '/pedido/formulario',
            '/pedido/formularioReferencia',
            '/pedido/gestionaReferencia',
            '/pedido/modalcarrito',
            '/pedido/navcarrito',
            '/stock',
            '/stock/formulario',
            '/stock/entradaStock',
            '/stock/salidaStock',
            '/stock/nuevaSalida',
            '/stock/nuevoStock',
            '/stock/salida',
            '/inventario/entrada',
            '/inventario/salida',
            '/inventario',
            '/inventario/formulario',
            '/auth/crear_cuenta',
            '/auth/actualizar_cuenta',
            '/auth/confirmar_cuenta',
            '/auth/formulario_cuenta',
            '/auth/mostrar',
            '/auth/mensaje', 
            '/medida',
            '/medida/crear',
            '/medida/actualizar',
            '/medida/formulario',
            
            '/recetas/mostrar',
            '/recetas/crear',
            '/recetas/crearIngredientes',
            '/recetas/carritoIngredientes',
            '/recetas/guardarRecetaIngredientes',

            // Rutas para el carrito de ventas
            '/ventas',
            '/ventas/carrito',
            '/ventas/eliminarProductoCarrito',
            '/ventas/vaciarCarritoVentas',
            '/ventas/realizarVenta',
            
            '/cobros/seleccionarCliente',
            '/cobros/mostrar',



            '/reportesDefectos',
            '/reportesDefectos/crear',


        ];

        //ACCEDER A LAS RUTAS

        if(in_array($currentUrl, $rutas_login)) {
            include_once __DIR__ . '/views/main-layout.php';
        }

        //debug($_SESSION);

        if(in_array($currentUrl, $rutas_admin)) {
            if(isAdmin()){
                include_once __DIR__ . '/views/admin-layout.php';
            } else if (isEncargado()){
                include_once __DIR__ . '/views/encargado-layout.php';
            }        
        }




        //  if(in_array($currentUrl, $rutas_layout)) {
        //       include_once __DIR__ . '/views/main-layout.php';
        //  } else {
        //       include_once __DIR__ . '/views/admin-layout.php';
        //  }

        //  if(empty($_SESSION)){
        //     if(in_array($currentUrl, $rutas_layout)) {
        //         include_once __DIR__ . '/views/main-layout.php';
        //     }
        // } else if(!empty($_SESSION)){
        //     if(in_array($currentUrl, $rutas_layout)) {
        //         include_once __DIR__ . '/views/main-layout.php';
        //     } else if ($_SESSION['rol'] == 'Administrador'){
        //         include_once __DIR__ . '/views/admin-layout.php';
        //     } else if($_SESSION['rol'] == 'Encargado'){
        //         include_once __DIR__ . '/views/encargado-layout.php';
        //     }
        // }
        

        // if(in_array($currentUrl, $rutas_layout)) {
        //     include_once __DIR__ . '/views/main-layout.php';
        // } else if($_SESSION['rol'] == 'Encargado'){
        //     include_once __DIR__ . '/views/encargado-layout.php';
        // } else if ($_SESSION['rol'] == 'Administrador') {
        //     include_once __DIR__ . '/views/admin-layout.php';
        // } else {
        //     include_once __DIR__ . '/views/main-layout.php';
        //     header('Location: /templates/error404');
        // }


        //  switch (in_array($currentUrl, $rutas_layout)) {
        //     case 1:
        //         $_SESSION['rol'] = 1;
        //         include_once __DIR__ . '/views/layout.php';
        //         break;
        //     case 2:
        //         $_SESSION['rol'] = 2;
        //         include_once __DIR__ . '/views/sidebar-layout.php';
        //         break;
        //     case 3:
        //         $_SESSION['rol'] = 3;
        //         include_once __DIR__ . '/views/sidebar-layout.php';
        //         break;

        //     default:
        //         include_once __DIR__ . '/views/layout.php';
        // }


        // if(str_contains($currentUrl, '/auth/login')) {
        //     include_once __DIR__ . '/views/layout.php';
        // } else if(str_contains($currentUrl, '/auth/olvide_password')){
        //     include_once __DIR__ . '/views/layout.php';
        // } else if(str_contains($currentUrl, '/auth/cambiar_password')){
        //     include_once __DIR__ . '/views/layout.php';
        // }else {
        //     include_once __DIR__ . '/views/sidebar-layout.php';
        // }



    }
}
