<?php

namespace Model;

class ReporteDefecto extends ActiveRecord {
    protected static $tabla = 'reportes_defectos';
    protected static $columnasDB = ['id', 'usuario_id', 'producto_id', 'cantidad', 'observacion', 'fecha_reporte'];

    public $id;
    public $usuario_id;
    public $producto_id;
    public $cantidad;
    public $observacion;
    public $fecha_reporte;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->usuario_id = $args['usuario_id'] ?? '';
        $this->producto_id = $args['producto_id'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->observacion = $args['observacion'] ?? '';
        $this->fecha_reporte = $args['fecha_reporte'] ?? date('Y-m-d H:i:s');
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
