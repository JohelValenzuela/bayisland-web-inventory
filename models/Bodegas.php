<?php

namespace Model;

class Bodegas extends ActiveRecord {
    protected static $tabla = 'bodegas';
    protected static $columnasDB = ['id', 'nombre', 'ubicacion'];

    public $id;
    public $nombre;
    public $ubicacion;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->ubicacion = $args['ubicacion'] ?? '';
    }

    public function validar() {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre de la bodega es obligatorio';
        }

        if (!$this->ubicacion) {
            self::$alertas['error'][] = 'La ubicación de la bodega es obligatoria';
        }

        return self::$alertas;
    }
}
