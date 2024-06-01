<?php

namespace Model;

class MaestroPedido extends ActiveRecord {

    // Tabla
    protected static $tabla = 'maestro_pedido';

    // Columnas
    protected static $columnasDB = ['id', 'referencia', 'estado', 'usuarioId', 'usuarioIdAprueba', 'fechaCreacion'];

    // Atributos
    public $id;
    public $referencia;
    public $estado;
    public $usuarioId;
    public $usuarioIdAprueba;
    public $fechaCreacion;

    // Constructor de atributos
    public function __construct($args = []){
        $this->id = $args['id'] ?? 'NULL' ;
        $this->referencia = $args['referencia'] ?? '';
        $this->estado = $args['estado'] ?? '';
        $this->usuarioId = $args['usuarioId'] ?? '';
        $this->usuarioIdAprueba = $args['usuarioIdAprueba'] ?? '';
        $this->fechaCreacion = $args['fechaCreacion'] ?? '';
    }

    public function validar() {

        //? SE CREA AUTOMATICO
        //* - id
        //* - referencia
        //* - estado
        //* - usuarioId
        //* - usuarioIdAprueba
        //* - fechaCreacion
        

        if(!$this->estado) {
            self::$alertas['error'][] = "El estado de la categoría es obligatorio";
        }

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