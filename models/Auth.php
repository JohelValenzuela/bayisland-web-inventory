<?php

namespace Model;

class Auth extends ActiveRecord {

    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'correo', 'username', 'password', 'token', 'tipo_usuario', 'confirmado', 'estado', 'rolId'];

    public $id;
    public $nombre;
    public $apellido;
    public $correo;
    public $username;
    public $password;
    public $token;
    public $tipo_usuario;
    public $confirmado;
    public $estado;
    public $rolId; // Campo nuevo para el rol del usuario

    public function __construct($args = []) {
        $this->id = $args['id'] ?? NULL;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->correo = $args['correo'] ?? '';
        $this->username = $args['username'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->tipo_usuario = $args['tipo_usuario'] ?? 'regular';
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->estado = $args['estado'] ?? 'Activo';
        $this->rolId = $args['rolId'] ?? NULL; // Inicializar el rol del usuario
    }

    // Mensajes de validación para la creación de un usuario
    public function validarNuevoUsuario() {

        if(!$this->nombre){
            self::$alertas['error'][] = "Escribe un nombre de usuario";
        }

        if(!$this->apellido){
            self::$alertas['error'][] = "Escribe el apellido de usuario";
        }

        if(!$this->correo){
            self::$alertas['error'][] = "Escribe un correo electrónico";
        }

        if(!$this->password){
            self::$alertas['error'][] = "Escribe una contraseña";
        }

        if(strlen($this->password) < 8){
            self::$alertas['error'][] = "La contraseña debe contener al menos 8 caracteres";
        }

        if(!$this->estado) {
            self::$alertas['error'][] = "El estado del usuario es obligatorio";
        }

        if(!$this->rolId) {
            self::$alertas['error'][] = "Selecciona un rol para el usuario";
        }

        return self::$alertas;
    }

    public function validarNuevoUsuarioTemporal() {

        if(!$this->nombre){
            self::$alertas['error'][] = "Escribe un nombre de usuario";
        }

        if(!$this->apellido){
            self::$alertas['error'][] = "Escribe el apellido de usuario";
        }

        if(!$this->estado) {
            self::$alertas['error'][] = "El estado del usuario es obligatorio";
        }

        return self::$alertas;
    }

    public function validarRolUsuario() {

        if(!$this->rolId){
            self::$alertas['error'][] = "Selecciona un rol para el usuario";
        }

        return self::$alertas;
    }

    public function validarLogin() {

        if(!$this->correo){
            self::$alertas['error'][] = "El correo electrónico es obligatorio";
        }

        if(!$this->password){
            self::$alertas['error'][] = "La contraseña es obligatoria";
        }

        return self::$alertas;
    }

    public function validarCorreo() {
        if(!$this->correo){
            self::$alertas['error'][] = "El correo electrónico es obligatorio";
        }

        return self::$alertas;
    }

    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'La nueva contraseña es obligatoria';
        }

        if(strlen($this->password) < 8){
            self::$alertas['error'][] = "La contraseña debe contener al menos 8 caracteres";
        }

        return self::$alertas;
    }

    // Genera un nombre de usuario a partir del nombre y apellido
    public static function generarUsername($nombre, $apellido) {
        // Limpiar y convertir el nombre y apellido a minúsculas
        $nombre = strtolower(trim($nombre));
        $apellido = strtolower(trim($apellido));
        
        // Reemplazar espacios y caracteres especiales
        $nombre = preg_replace('/[^a-z0-9]/', '', $nombre);
        $apellido = preg_replace('/[^a-z0-9]/', '', $apellido);
    
        // Generar un número aleatorio
        $numeroRandom = rand(10, 99);
    
        // Crear el nombre de usuario
        $username = $nombre . '' . $apellido . $numeroRandom;
    
        return $username;
    }
    
    function generarPassword($username) {
        // Añadimos algunos caracteres especiales y números al nombre de usuario
        $caracteresEspeciales = ['!', '@', '#', '$', '%', '^', '&', '*'];
        $caracterEspecial = $caracteresEspeciales[array_rand($caracteresEspeciales)];
        $numeroRandom = rand(10, 99);
    
        // Combinamos el nombre de usuario con el carácter especial y número
        return $username . $caracterEspecial . $numeroRandom;
    }

    // Revisa si el usuario existe
    public function existeUsuario() {

        // Expresión regular para validar el correo electrónico sin caracteres especiales
        $patron = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

        // Elimina caracteres no válidos
        $email = filter_var($this->correo, FILTER_SANITIZE_EMAIL);

        // Validar e-mail
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Valida el correo ingresado con la expresión regular
            if (preg_match($patron, $email)) {
                // Query SQL. Se leen los datos de la DB.
                $query = "SELECT * FROM " . self::$tabla . " WHERE correo = '" . $email . "' LIMIT 1";
                
                // Consulta SQL. Se guardan los datos en resultado
                $resultado = self::$db->query($query);
        
                // Si el usuario ya está registrado, se agrega a las alertas
                if($resultado->num_rows) {
                    self::$alertas['error'][] = 'El usuario ya está registrado';
                }
            } else {
                self::$alertas['error'][] = 'El correo ingresado no es válido';
            }
        } else {
            self::$alertas['error'][] = 'El correo ingresado no es válido';
        }
    
        // Retorna el resultado
        return $resultado;
    }

    public function hashPassword() {
        // Lee el password escrito, aplica la función y lo vuelve a asignar en el mismo lugar.
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();
    }

    public function passwordVerificado($password) {

        // Verifica si la contraseña es correcta
        $resultado = password_verify($password, $this->password);

        // Si la contraseña es incorrecta o no está confirmado
        if(!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = "La contraseña es incorrecta o su cuenta no ha sido confirmada";
        } else {
            return true;
        }
    }
}
