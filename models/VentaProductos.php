<?php

namespace Model;

class VentaProductos extends ActiveRecord {
    protected static $tabla = 'venta_productos';
    protected static $columnasDB = ['id', 'venta_id', 'producto_id', 'receta_id', 'cantidad', 'precio', 'metodoPago']; // Agregar los nuevos campos

    public $id;
    public $venta_id;
    public $producto_id;
    public $receta_id;
    public $cantidad;
    public $precio;
    public $metodoPago;
    public $cantidad_vendida ;
    public $total_ingresos ;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->venta_id = $args['venta_id'] ?? 0;
        $this->producto_id = $args['producto_id'] ?? 0;
        $this->receta_id = $args['receta_id'] ?? 0;
        $this->cantidad = $args['cantidad'] ?? 0;
        $this->precio = $args['precio'] ?? 0;
        $this->metodoPago = $args['metodoPago'] ?? '';
        $this->cantidad_vendida  = $args['cantidad_vendida '] ?? '';
        $this->total_ingresos  = $args['total_ingresos '] ?? '';
    }

    public function validar() {
        if(!$this->venta_id) {
            self::$alertas['error'][] = "Elige una venta de cliente";
        }

        if(!$this->producto_id) {
            self::$alertas['error'][] = "Elige un producto";
        }

        if(!$this->receta_id) {
            self::$alertas['error'][] = "Elige una receta";
        }

        if(!$this->cantidad) {
            self::$alertas['error'][] = "Digita una cantidad de producto";
        }

        if(!$this->precio) {
            self::$alertas['error'][] = "Digita un precio para el producto";
        }

        return self::$alertas;
    }

}
