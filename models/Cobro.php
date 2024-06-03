<?php

namespace Model;

class Cobro extends ActiveRecord {

    protected static $tabla = 'cobros';
    protected static $columnasDB = ['id', 'venta_id', 'metodo_pago', 'cantidad_pagada', 'cliente_id', 'fecha_registro'];

    public $id;
    public $venta_id;
    public $metodo_pago;
    public $cantidad_pagada;
    public $cliente_id;
    public $fecha_registro;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->venta_id = $args['venta_id'] ?? '';
        $this->metodo_pago = $args['metodo_pago'] ?? '';
        $this->cantidad_pagada = $args['cantidad_pagada'] ?? '';
        $this->cliente_id = $args['cliente_id'] ?? '';
        $this->fecha_registro = $args['fecha_registro'] ?? '';
    }

    public function validar() {
        // Aquí puedes implementar las validaciones necesarias, si las hubiera
        return [];
    }

}
