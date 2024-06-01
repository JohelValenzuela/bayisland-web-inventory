<?php

namespace Model;

class Categoria extends ActiveRecord {

    // Tabla
    protected static $tabla = 'categoria';

    // Columnas
    protected static $columnasDB = ['id', 'nombre', 'estado'];

    // Atributos
    public $id;
    public $nombre;
    public $estado;

    // Constructor de atributos
    public function __construct($args = []){
        $this->id = $args['id'] ?? NULL ;
        $this->nombre = $args['nombre'] ?? '';
        $this->estado = $args['estado'] ?? '';
    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = "El nombre de la categoría es obligatorio";
        }

        if(!$this->estado) {
            self::$alertas['error'][] = "El estado de la categoría es obligatorio";
        }

        return self::$alertas;
    }

    // Revisa si la categoria existe
    public function existeCategoria() {
        // Query SQL. Se leen los datos de la DB.
        $query = "SELECT * FROM " . self::$tabla . " WHERE nombre = '" . $this->nombre . "' LIMIT 1";
            
        // Consulta SQL. Se guardan los datos en resultado
        $resultado = self::$db->query($query);
    
        // Si el usuario ya está registrado, se agrega a las alertas
        if($resultado->num_rows) {
            self::$alertas['error'][] = 'La categoría ya existe';
        }

        // Retorna el resultado
        return $resultado;
    }



}