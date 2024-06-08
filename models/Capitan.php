<?php

namespace Model;

class Capitan extends ActiveRecord {
    protected static $tabla = 'capitanes';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }

    public function validar() {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del capitán es obligatorio';
        }
        return self::$alertas;
    }
}
