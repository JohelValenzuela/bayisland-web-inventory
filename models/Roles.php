<?php

namespace Model;

class Roles extends ActiveRecord {

    // Tabla
    protected static $tabla = 'roles';

    // Columnas
    protected static $columnasDB = ['id', 'tipoRol'];

    // Atributos
    public $id;
    public $tipoRol;

    // Constructor de atributos
    public function __construct($args = []){
        $this->id = $args['id'] ?? NULL ;
        $this->tipoRol = $args['tipoRol'] ?? '';
    }

    public function validar() {
        if(!$this->tipoRol) {
            self::$alertas['error'][] = "El nombre del rol es obligatorio";
        }

        return self::$alertas;
    }



}