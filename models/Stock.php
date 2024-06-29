<?php

namespace Model;

class Stock extends ActiveRecord {

    // Tabla
    protected static $tabla = 'stock';

    // Columnas
    protected static $columnasDB = ['id', 'productoId','cantidad', 'movimiento', 'usuarioId', 'fechaCreacion', 'estado', 'bodegaId'];

    // Atributos
    public $id;
    public $productoId;
    public $cantidad;
    public $movimiento;
    public $usuarioId;
    public $fechaCreacion;
    public $estado;  
    public $bodegaId;  



    // Constructor de atributos
    public function __construct($args = []){
        $this->id = $args['id'] ?? NULL ;
        $this->productoId = $args['productoId'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->movimiento = $args['movimiento'] ?? '';
        $this->usuarioId = $args['usuarioId'] ?? '';
        $this->fechaCreacion = $args['fechaCreacion'] ?? '';
        $this->estado = $args['estado'] ?? '';
        $this->bodegaId = $args['bodegaId'] ?? '';
    }

    public function validar() {


        if(!$this->productoId) {
            self::$alertas['error'][] = "Selecciona un producto";
        }

        if(!$this->cantidad) {
            self::$alertas['error'][] = "Digite la cantidad de empaques";
        }

        if(!$this->estado) {
            self::$alertas['error'][] = "El estado de producto es obligatorio";
        }

        if(!$this->bodegaId) {
            self::$alertas['error'][] = "Selecciona una bodega";
        }

        return self::$alertas;
    }

    public function existeStock($productoId, $bodegaId) {
        // Query SQL. Se leen los datos de la DB.
        $query = "SELECT * FROM " . self::$tabla . " WHERE productoId = {$productoId} && bodegaId = {$bodegaId}";

        //debug($query);
        
        // Consulta SQL. Se guardan los datos en resultado
        $resultado = self::$db->query($query);
        
        // Si el usuario ya está registrado, se agrega a las alertas
        if($resultado->num_rows) {
            //self::$alertas['exito'][] = 'La referencia es válida';
        } else {
            // self::$alertas['error'][] = 'El número de referencia no existe';
        }
        //debug($resultado);
        // Retorna el resultado
        return $resultado;
    }




}