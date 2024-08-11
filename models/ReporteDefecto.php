<?php

namespace Model;

class ReporteDefecto extends ActiveRecord {
    protected static $tabla = 'reportes_defectos';
    protected static $columnasDB = ['id', 'usuario_id', 'producto_id', 'receta_id', 'cantidad', 'observacion', 'fecha_reporte', 'estado', 'bodegaId'];

    public $id;
    public $usuario_id;
    public $producto_id;
    public $receta_id;
    public $cantidad;
    public $observacion;
    public $fecha_reporte;
    public $estado;
    public $bodegaId; 
    public $bodega; 
    public $cantidad_defectos; 

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->usuario_id = $args['usuario_id'] ?? '';
        $this->producto_id = $args['producto_id'] ?? 0;
        $this->receta_id = $args['receta_id'] ?? 0;
        $this->cantidad = $args['cantidad'] ?? 0;
        $this->observacion = $args['observacion'] ?? '';
        $this->fecha_reporte = $args['fecha_reporte'] ?? date('Y-m-d H:i:s');
        $this->estado = $args['estado'] ?? 'pendiente'; // Estado por defecto
        $this->bodegaId = $args['bodegaId'] ?? '';
        $this->bodega  = $args['bodega'] ?? '';
        $this->cantidad_defectos  = $args['cantidad_defectos'] ?? '';
    }

    public function validar() {
        if (!$this->usuario_id) {
            self::$alertas['error'][] = 'El usuario es obligatorio';
        }
        if (!$this->producto_id && !$this->receta_id) {
            self::$alertas['error'][] = 'Debe seleccionar un producto o una receta';
        }
        if (!$this->cantidad) {
            self::$alertas['error'][] = 'La cantidad es obligatoria';
        }
        if(!$this->bodegaId) {
            self::$alertas['error'][] = "Selecciona una bodega";
        }
        return self::$alertas;
    }
    
}
