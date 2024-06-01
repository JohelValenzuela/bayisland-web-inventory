<?php

namespace Model;

class DetallePedido extends ActiveRecord {

    // Tabla
    protected static $tabla = 'detalle_pedido';

    // Columnas
    protected static $columnasDB = ['id', 'maestroId', 'productoId', 'cantidad', 'observacion'];

    // Atributos
    public $id;
    public $maestroId;
    public $productoId;
    public $cantidad;
    public $observacion;

    // Constructor de atributos
    public function __construct($args = []){
        $this->id = $args['id'] ?? 'NULL' ;
        $this->maestroId = $args['maestroId'] ?? '';
        $this->productoId = $args['productoId'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->observacion = $args['observacion'] ?? '';
    }


    public function validar() {

        //? SE CREA AUTOMATICO
        //* - id
        //* - maestroId
        //* - productoId

        if(!$this->cantidad) {
            self::$alertas['error'][] = "Digite una cantidad por ordenar";
        }

        if(!$this->observacion) {
            self::$alertas['error'][] = "Escriba una observacion";
        }

        return self::$alertas;
    }

}