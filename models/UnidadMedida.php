<?php

namespace Model;

class UnidadMedida extends ActiveRecord {

    // Tabla
    protected static $tabla = 'medidas';

    // Columnas
    protected static $columnasDB = ['id', 'nombre', 'sigla', 'estado'];

    // Atributos
    public $id;
    public $nombre;
    public $sigla;
    public $estado;

    // Constructor de atributos
    public function __construct($args = []){
        $this->id = $args['id'] ?? 'NULL' ;
        $this->nombre = $args['nombre'] ?? '';
        $this->sigla = $args['sigla'] ?? '';
        $this->estado = $args['estado'] ?? '';
    }


    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = "La unidad de medida es obligatoria";
        }

        if(!$this->sigla) {
            self::$alertas['error'][] = "La sigla para la medida es obligatoria";
        }

        if(!$this->estado) {
            self::$alertas['error'][] = "El estado de la es obligatorio";
        }

        return self::$alertas;
    }

    // Revisa si la medida existe
    public function existeMedida() {
        // Query SQL. Se leen los datos de la DB.
        $query = "SELECT * FROM " . self::$tabla . " WHERE nombre = '" . $this->nombre . "' LIMIT 1";
        
        // Consulta SQL. Se guardan los datos en resultado
        $resultado = self::$db->query($query);
    
        // Si el usuario ya está registrado, se agrega a las alertas
        if($resultado->num_rows) {
            self::$alertas['error'][] = 'La medida ya existe';
        }

        // Retorna el resultado
        return $resultado;
    }



}