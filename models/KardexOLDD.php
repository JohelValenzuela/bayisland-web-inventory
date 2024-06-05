<?php

namespace Model;

class Kardex extends ActiveRecord {

    // Tabla
    protected static $tabla = 'kardex';

    // Columnas
    protected static $columnasDB = ['id', 'referencia', 'productoId', 'cantidad', 'operacion', 'operacion', 'estado', 'usuarioId', 'fechaCreacion'];

    // Atributos
    public $id;
    public $referencia;
    public $productoId;
    public $cantidad;
    public $operacion;
    public $estado; 
    public $usuarioId; 
    public $fechaCreacion;



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
    }

    public function validar() {


        if(!$this->productoId) {
            self::$alertas['error'][] = "El nombre del producto es obligatorio";
        }

        if(!$this->cantidad) {
            self::$alertas['error'][] = "La cantidad de unidades por empaque es obligatoria";
        }

        if(!$this->estado) {
            self::$alertas['error'][] = "El estado de producto es obligatorio";
        }



        return self::$alertas;
    }




}