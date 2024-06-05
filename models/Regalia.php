<?php

namespace Model;

class Regalia extends ActiveRecord {
    protected static $tabla = 'regalias';
    protected static $columnasDB = ['id', 'usuario_id', 'producto_id', 'cantidad', 'observacion', 'fecha_regalia', 'estado'];

    public $id;
    public $usuario_id;
    public $producto_id;
    public $cantidad;
    public $observacion;
    public $fecha_regalia;
    public $estado;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->usuario_id = $args['usuario_id'] ?? '';
        $this->producto_id = $args['producto_id'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->observacion = $args['observacion'] ?? '';
        $this->fecha_regalia = $args['fecha_regalia'] ?? date('Y-m-d H:i:s');
        $this->estado = $args['estado'] ?? 'pendiente'; // Estado por defecto
    }

    public function validar() {
        if (!$this->usuario_id) {
            self::$alertas['error'][] = 'El usuario es obligatorio';
        }
        if (!$this->producto_id) {
            self::$alertas['error'][] = 'El producto es obligatorio';
        }
        if (!$this->cantidad) {
            self::$alertas['error'][] = 'La cantidad es obligatoria';
        }
        return self::$alertas;
    }
}
