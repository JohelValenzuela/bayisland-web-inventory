<?php

namespace Model;

class Guia extends ActiveRecord {
    protected static $tabla = 'guias';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }

    public function validar() {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del guía es obligatorio';
        }
        return self::$alertas;
    }
}
