<?php

namespace Model;

class Cliente extends ActiveRecord {

    protected static $tabla = 'clientes';
    protected static $columnasDB = ['id', 'nombre', 'codigo_brazalete'];

    public $id;
    public $nombre;
    public $codigo_brazalete;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->codigo_brazalete = $args['codigo_brazalete'] ?? '';
    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = "El nombre del cliente es obligatorio";
        }

        if(!$this->codigo_brazalete) {
            self::$alertas['error'][] = "Ingresa el código de brazalete";
        }

        return self::$alertas;
    }

}