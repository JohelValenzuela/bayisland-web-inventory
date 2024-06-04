<?php

namespace Controllers;
use Classes\Correo;
use Classes\Paginacion;
use Model\Auth;
use Model\Roles;
use MVC\Router;

class AuthController {

    public static function mostrar(Router $router){

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $usuarios = Auth::all();
        if(!empty($usuarios)){
            
            $usuarios = Auth::all();
            $roles = Roles::all();


            foreach ($usuarios as $usuario) {
                $usuario->rol = Roles::find($usuario->rolId);
                //debug($usuarios);
            }


            // muestra mensaje condicional
            $resultado = $_GET['resultado'] ?? null; //le asigna el valor null en caso de que no esté resultado
            
            $router->render('auth/mostrar', [
                'usuarios' => $usuarios,
                'roles' => $roles,
                'resultado' => $resultado
            ]);
        } else {
            $router->render('auth/mostrar', []);
        }
    }

    public static function login(Router $router){

        $roles = Roles::all();
        $alertas = [];

        // Endpoint de la API de Open Exchange Rates
        $endpoint = "https://open.er-api.com/v6/latest/USD";
    
        // Realizar una solicitud GET a la API
        $response = file_get_contents($endpoint);
        
        // Decodificar la respuesta JSON
        $data = json_decode($response, true);
        //debug($data);
        
        // Verificar si se obtuvo una respuesta válida
        if ($data && isset($data['rates']['CRC'])) {
            // Devolver el tipo de cambio del dólar a colones costarricenses
            $_SESSION['tipo_cambio'] = $data['rates']['CRC'];
        } else {
            // Si no se pudo obtener el tipo de cambio, devolver un valor predeterminado
            $_SESSION['tipo_cambio'] = 0;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Auth($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)) { // Comprobar si el usuario existe
                $usuarios = Auth::where('correo', $auth->correo); 
                
                if($usuarios) { // Verifica password
                    if ($usuarios->passwordVerificado($auth->password)) {
                        
                        // Autenticar al usuario
                        $_SESSION['id'] = $usuarios->id;
                        $_SESSION['nombre'] = $usuarios->nombre . " " . $usuarios->apellido;
                        $_SESSION['correo'] = $usuarios->correo;
                        $_SESSION['rol'] = $usuarios->rolId;
                        $_SESSION['login'] = true;
                        
                        // Visualizar Roles
                        switch ($usuarios->rolId) {
                            case 1:
                                $_SESSION['rol'] = 'Visor (Solo Lectura)';
                                header ('Location: /dashboard');
                                break;
                            case 2:
                                $_SESSION['rol'] = 'Encargado';
                                header ('Location: /pedido');
                                break;
                            case 3:
                                $_SESSION['rol'] = 'Administrador';
                                header ('Location: /dashboard');
                                break;

                            default:
                                $_SESSION['rol'] = '';
                                header ('Location: /login');
                        }
                    }
                } else {
                    Auth::setAlerta('error', 'Este usuario no existe');
                }
            }
        }

        $alertas = Auth::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas,
            'roles' => $roles
        ]);
    }

    public static function crear_cuenta(Router $router){

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $usuarios = new Auth;
        $roles = Roles::all();

        // Genera una password única
        $tempPassword = uniqid();
        $usuarios->password = $tempPassword;

        // Alertas 
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuarios->sincronizar($_POST);
            $alertas = $usuarios->validarNuevoUsuario();
            $alertas = $usuarios->validarRolUsuario();

            // Revisa que alertas esté vacio
            if(empty($alertas)) {
                // Verifica que el usuario no exista
                $resultado = $usuarios->existeUsuario();

                // Si existe se llena alertas, se envia la alerta a la vista
                if($resultado ->num_rows) {
                    $alertas = Auth::getAlertas();
                } else {
              
                    // Si no existe Realiza Hash al Password
                    $usuarios->hashPassword();

                    // Genera un token unico
                    $usuarios->crearToken();
                    // Envia el correo con el token
                    $nombrecompleto = $usuarios->nombre . ' ' . $usuarios->apellido;
                    $correo = new Correo($nombrecompleto, $usuarios->correo, $usuarios->token, $tempPassword);
                    
                    $correo->enviarConfirmacion();
                    $correo->enviarIntruccionesPassword();
                    
                    // Crea el usuario
                    $resultado = $usuarios->guardar();

                    if($resultado) { // Si se guarda el usuario envia una alerta
                        header('Location: /auth/mensaje');
                    }
                }
            }
            
        }
        

        $router->render('auth/crear_cuenta', [
            'usuarios' => $usuarios,
            'roles' => $roles,
            'alertas' => $alertas
        ]);
    }

    public static function confirmar_cuenta(Router $router){

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $alertas = [];

     
        $token = s($_GET['token']);  // Lee el token
        $usuarios = Auth::where('token', $token);  // Busca los resultados según el token

        if(empty($usuarios)  || $usuarios === '') {
            // Si no hay resultados, muestra alerta de error
            Auth::setAlerta('error', 'Token Inválido');
        } else {
            // Actualizar usuario a Confirmado y elimina el token
            $usuarios->confirmado = "1";
            $usuarios->token = '';

            // Guarda al usuario
            $usuarios->guardar();
            Auth::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }
        $alertas = Auth::getAlertas();
        $router->render('auth/confirmar_cuenta', [
            'alertas'=> $alertas    
        ]);
    }

    public static function olvide_password(Router $router){

        $alertas = [];
        

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Auth($_POST);
            $alertas = $auth->validarCorreo();

            if(empty($alertas)) {
                $usuarios = Auth::where('correo', $auth->correo);

                if($usuarios && $usuarios->confirmado === "1") {
                    // Genera nuevo token para cambiar password
                    $usuarios->crearToken();
                    $usuarios->guardar();

                    // Enviar correo
                    $nombrecompleto = $usuarios->nombre . ' ' . $usuarios->apellido;
                    $correo = new Correo($nombrecompleto, $usuarios->correo, $usuarios->token, $usuarios->password);
                    $correo->enviarInstrucciones();


                    Auth::setAlerta('exito', 'Revisa tu correo electrónico');
                } else {
                    Auth::setAlerta('error', 'Este usuario no existe o no está verificado');
                }
            }

        }
        $alertas = Auth::getAlertas();
        $router->render('auth/olvide_password', [
            'alertas'=> $alertas 
        ]);
    }

    public static function cambiar_password(Router $router){

        

        $alertas = [];
        $error = false;

        $token = s($_GET['token']);  // Lee el token
        $usuarios = Auth::where('token', $token);  // Busca los resultados según el token

        if(empty($usuarios)) {
            Auth::setAlerta('error', 'Token inválido');
            $error = true;
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer password
            $password = new Auth($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                $usuarios->password = null;
                $usuarios->password = $password->password; 
                
                $usuarios->hashPassword();   

                $usuarios->token = '';
                
                // Guardar
                $resultado = $usuarios->guardar();

                if($resultado){
                    header ('Location: /');
                }
            }           
        }
        $alertas = Auth::getAlertas();
        $router->render('auth/cambiar_password', [
            'alertas'=> $alertas,
            'error' => $error
        ]);
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje', []);
    }

    public static function logout(){
        session_start();        
        $_SESSION = []; // Limpia el array de session, dejandolo sin datos y perdiendo autenticación.
        header ('Location: /');
    }

    public static function actualizar_cuenta(Router $router) {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $roles = Roles::all();

        $id = validarORedireccionar('/auth/mostrar');      
        $usuarios = Auth::find($id);

        // Alertas 
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuarios->sincronizar($_POST);
            $alertas = $usuarios->validarNuevoUsuario();
            $alertas = $usuarios->validarRolUsuario();

            // Revisa que alertas esté vacio
            if(empty($alertas)) {

                if($usuarios->estado === "Inactivo"){
                    $usuarios->confirmado = "0";
                } else if($usuarios->estado === "Activo"){
                    $usuarios->confirmado = "1";
                }
                
                    // Si no existe Realiza Hash al Password
                    $usuarios->hashPassword();

                    // Crea el usuario
                    $resultado = $usuarios->guardar();

                    if($resultado) { // Si se guarda el usuario envia una alerta                       
                        Auth::setAlerta('exito', 'Usuario actualizado correctamente');
                        //header('Location: /auth/mostrar');
                    }
                }
            }

        $alertas = Auth::getAlertas();
        $router->render('auth/actualizar_cuenta', [
            'usuarios' => $usuarios,
            'roles' => $roles,
            'alertas' => $alertas
        ]);
    }

    public static function desactivar(Router $router) {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }
      
      if($_SERVER['REQUEST_METHOD'] === 'POST') {     
            $id = $_POST['id'];
            $usuario = Auth::find($id);
            $usuario->estado = "Inactivo";
            $usuario->confirmado = "0";
            $usuario->guardar();

            header('Location: /auth/mostrar');
          
      }
    }

    public static function activar() {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }
        
      if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $usuario = Auth::find($id);
            $usuario->estado = "Activo";
            $usuario->confirmado = "1";
            $usuario->guardar();
            
            header('Location: /auth/mostrar');
      }
    }


}
