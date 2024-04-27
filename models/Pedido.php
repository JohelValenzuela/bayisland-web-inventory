<?php

namespace Model;

class Pedido extends ActiveRecord {

    // Tabla
    protected static $tabla = 'pedido';

    // Columnas
    protected static $columnasDB = ['id', 'referencia', 'categoriaId', 'productoId', 'cantidad', 'observacion', 'estado', 'usuarioId', 'fechaCreacion'];

    // Atributos
    public $id;
    public $referencia;
    public $categoriaId;
    public $productoId;
    public $cantidad;
    public $observacion;
    public $estado;
    public $usuarioId;
    public $fechaCreacion;

    // Constructor de atributos
    public function __construct($args = []){
        $this->id = $args['id'] ?? 'NULL' ;
        $this->referencia = $args['referencia'] ?? '';
        $this->categoriaId = $args['categoriaId'] ?? '';
        $this->productoId = $args['productoId'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->observacion = $args['observacion'] ?? '';
        $this->estado = $args['estado'] ?? 'Pendiente';
        $this->usuarioId = $args['usuarioId'] ?? '';
        $this->fechaCreacion = $args['fechaCreacion'] ?? '';
    }


    public function validar() {
        
        // if(!$this->referencia) {
        //     self::$alertas['error'][] = "La referencia se crea automatica";
        // }

        if(!$this->categoriaId) {
            self::$alertas['error'][] = "Selecciona una categoría";
        }

        if(!$this->productoId) {
            self::$alertas['error'][] = "Selecciona un producto";
        }

        // if(!$this->usuarioId) {
        //     self::$alertas['error'][] = "El usuario se crea automatico";
        // }

        if(!$this->cantidad) {
            self::$alertas['error'][] = "Digite una cantidad por ordenar";
        }

        if(!$this->observacion) {
            self::$alertas['error'][] = "Escribe una observación";
        }

        // if(!$this->estado) {
        //     self::$alertas['error'][] = "El estado es obligatorio";
        // }

        // if(!$this->fechaCreacion) {
        //     self::$alertas['error'][] = "La fecha se crea automatica";
        // }

        return self::$alertas;
    }


    public function crearReferencia() {
        $this->referencia = uniqid();
    }

    
    public function existeReferencia($referencia) {
        // Query SQL. Se leen los datos de la DB.
        $query = "SELECT * FROM " . self::$tabla . " WHERE referencia = '{$referencia}'";
        
        // Consulta SQL. Se guardan los datos en resultado
        $resultado = self::$db->query($query);

        // Si el usuario ya está registrado, se agrega a las alertas
        if($resultado->num_rows) {
            //self::$alertas['exito'][] = 'La referencia es válida';
        } else {
            self::$alertas['error'][] = 'El número de referencia no existe';
        }
        //debug($resultado);
        // Retorna el resultado
        return $resultado;
    }
}