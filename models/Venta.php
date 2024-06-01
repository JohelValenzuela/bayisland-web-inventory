<?php

namespace Model;

class Venta extends ActiveRecord {
    protected static $tabla = 'ventas';
    protected static $columnasDB = ['id', 'cliente', 'fecha'];

    public $id;
    public $cliente;
    public $fecha;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->cliente = $args['cliente'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
    }

    public function validar() {
        if(!$this->cliente) {
            self::$alertas['error'][] = "Escribe el nombre del cliente";
        }

        return self::$alertas;
    }

    // // Revisa si la medida existe
    // public function existeMedida() {
    //     // Query SQL. Se leen los datos de la DB.
    //     $query = "SELECT * FROM " . self::$tabla . " WHERE nombre = '" . $this->nombre . "' LIMIT 1";
        
    //     // Consulta SQL. Se guardan los datos en resultado
    //     $resultado = self::$db->query($query);
    
    //     // Si el usuario ya está registrado, se agrega a las alertas
    //     if($resultado->num_rows) {
    //         self::$alertas['error'][] = 'La medida ya existe';
    //     }

    //     // Retorna el resultado
    //     return $resultado;
    // }



}