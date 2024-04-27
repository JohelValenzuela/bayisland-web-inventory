<?php

namespace Model;

class Auth extends ActiveRecord {

    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'correo', 'password', 'rolId', 'confirmado', 'token', 'estado'];

    public $id;
    public $nombre;
    public $apellido;
    public $correo;
    public $password;
    public $rolId;
    public $confirmado;
    public $token;
    public $estado;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? NULL;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->correo = $args['correo'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->rolId = $args['rolId'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->estado = $args['estado'] ?? '';
    }

    // Mensajes de validación para la creción de un usuario

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
            self::$alertas['error'][] = "La contraseña debe contener almenos 8 caracteres";
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
            self::$alertas['error'][] = "La contraseña debe contener almenos 8 caracteres";
        }

        return self::$alertas;
    }


    // Revisa si el usuario existe
    public function existeUsuario() {
        // Query SQL. Se leen los datos de la DB.
        $query = "SELECT * FROM " . self::$tabla . " WHERE correo = '" . $this->correo . "' LIMIT 1";
        
        // Consulta SQL. Se guardan los datos en resultado
        $resultado = self::$db->query($query);

        // Si el usuario ya está registrado, se agrega a las alertas
        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El usuario ya está registrado';
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

        // Si la password es incorrecta o no está confirmado
        if(!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = "La contraseña es incorrecta o su cuenta no ha sido confirmada";
        } else {
            return true;
        }
    }



    




}