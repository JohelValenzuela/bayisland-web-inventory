<?php

namespace Model;

class Inventario extends ActiveRecord {

    // Tabla
    protected static $tabla = 'kardex';

    // Columnas
    protected static $columnasDB = ['id', 'referencia', 'productoId', 'cantidadAnterior', 'operacion', 'cantidadEntrada', 'cantidadSalida', 'cantidadTotal', 'estado', 'usuarioId', 'fechaCreacion', 'bodegaId'];

    // Atributos
    public $id;
    public $referencia;
    public $productoId;
    public $cantidadAnterior;
    public $operacion;
    public $cantidadEntrada;
    public $cantidadSalida;
    public $cantidadTotal;
    public $estado; 
    public $usuarioId; 
    public $fechaCreacion;
    public $bodegaId; 
    public $bodega ; 
    public $entrada; 
    public $salida ; 
    public $total  ; 



    // Constructor de atributos
    public function __construct($args = []){
        $this->id = $args['id'] ?? NULL ;
        $this->referencia = $args['referencia'] ?? '';
        $this->productoId = $args['productoId'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->operacion = $args['operacion'] ?? '';
        $this->estado = $args['estado'] ?? '';
        $this->usuarioId = $args['usuarioId'] ?? '';
        $this->fechaCreacion = $args['fechaCreacion'] ?? '';
        $this->bodegaId = $args['bodegaId'] ?? '';
        $this->bodega  = $args['bodega'] ?? '';
        $this->entrada = $args['entrada'] ?? '';
        $this->salida  = $args['salida'] ?? '';
        $this->total   = $args['total'] ?? '';
    }

    public function validar() {


        if(!$this->productoId) {
            self::$alertas['error'][] = "Selecciona un producto";
        }

        if(!$this->cantidad) {
            self::$alertas['error'][] = "La cantidad de unidades por empaque es obligatoria";
        }

        if(!$this->estado) {
            self::$alertas['error'][] = "El estado de producto es obligatorio";
        }

        if(!$this->bodegaId) {
            self::$alertas['error'][] = "Selecciona una bodega";
        }



        return self::$alertas;
    }




}