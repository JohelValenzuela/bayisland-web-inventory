<?php

namespace Model;

class Cobro extends ActiveRecord {

    protected static $tabla = 'cobros';
    protected static $columnasDB = ['id', 'venta_id', 'metodo_pago', 'cantidad_pagada', 'cantidad_por_pagar', 'cliente_id', 'fecha_registro', 'estado', 'debe'];

    public $id;
    public $venta_id;
    public $metodo_pago;
    public $cantidad_pagada;
    public $cantidad_por_pagar; // Nuevo campo
    public $cliente_id;
    public $fecha_registro;
    public $estado;
    public $debe;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->venta_id = $args['venta_id'] ?? '';
        $this->metodo_pago = $args['metodo_pago'] ?? '';
        $this->cantidad_pagada = $args['cantidad_pagada'] ?? '';
        $this->cantidad_por_pagar = $args['cantidad_por_pagar'] ?? ''; // Nuevo campo
        $this->cliente_id = $args['cliente_id'] ?? '';
        $this->fecha_registro = $args['fecha_registro'] ?? '';
        $this->estado = $args['estado'] ?? '';
        $this->debe = $args['debe'] ?? '';
    }

    public function validar() {

        if($this->cantidad_pagada < $this->cantidad_por_pagar) {
            self::$alertas['error'][] = "La cantidad pagada debe ser mayor o igual que la cantidad por pagar.";
        }

        return self::$alertas;
    }

    public function setEstado() {
        if ($this->cantidad_pagada == $this->cantidad_por_pagar) {
            $this->estado = "Cancelado";
        } else {
            $this->estado = "Pendiente";
        }
    }

    public function setDebe() {
        if ($this->estado == "Pendiente") {
            $this->debe = $this->cantidad_por_pagar - $this->cantidad_pagada;
        } else {
            $this->debe = 0;
        }
    }


    
}
