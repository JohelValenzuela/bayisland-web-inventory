<?php

namespace Model;

class VentaUltimaHora extends ActiveRecord {
    protected static $tabla = 'ventas_ultima_hora';
    protected static $columnasDB = ['id', 'nombre_persona', 'nacionalidad', 'vendedor_nombre', 'cobrador_nombre', 'cantidad_personas', 'total_dolares', 'total_colones', 'fecha'];

    public $id;
    public $nombre_persona;
    public $nacionalidad;
    public $vendedor_nombre;
    public $cobrador_nombre;
    public $cantidad_personas;
    public $total_dolares;
    public $total_colones;
    public $fecha;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre_persona = $args['nombre_persona'] ?? '';
        $this->nacionalidad = $args['nacionalidad'] ?? '';
        $this->vendedor_nombre = $args['vendedor_nombre'] ?? '';
        $this->cobrador_nombre = $args['cobrador_nombre'] ?? '';
        $this->cantidad_personas = $args['cantidad_personas'] ?? 0;
        $this->total_dolares = $args['total_pagar'] ?? 0.0;
        $this->total_colones = $args['total_pagar'] ?? 0.0;
        $this->fecha = $args['fecha'] ?? date('Y-m-d H:i:s');
    }

    public function validar() {
        if (!$this->nombre_persona) {
            self::$alertas['error'][] = 'El nombre del cliente es obligatorio';
        }
        if (!$this->nacionalidad) {
            self::$alertas['error'][] = 'La nacionalidad es obligatoria';
        }
        if (!$this->cantidad_personas) {
            self::$alertas['error'][] = 'La cantidad de personas es obligatoria';
        }
        if (!$this->vendedor_nombre) {
            self::$alertas['error'][] = 'El nombre del vendedor es obligatorio';
        }
        if (!$this->cobrador_nombre) {
            self::$alertas['error'][] = 'El nombre del cobrador es obligatorio';
        }
        if (!$this->total_dolares && !$this->total_colones) {
            self::$alertas['error'][] = 'El total a pagar es obligatorio';
        }
        return self::$alertas;
    }
}
