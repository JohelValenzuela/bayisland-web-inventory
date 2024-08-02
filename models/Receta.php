<?php

namespace Model;

class Receta extends ActiveRecord {

    // Tabla
    protected static $tabla = 'recetas';

    // Columnas
    protected static $columnasDB = ['id', 'nombre', 'observacion'];

    // Atributos
    public $id;
    public $nombre;
    public $observacion;


    // Constructor de atributos
    public function __construct($args = []){
        $this->id = $args['id'] ?? NULL ;
        $this->nombre = $args['nombre'] ?? '';
        $this->observacion = $args['observacion'] ?? '';
    }

    public function validar() {


        if(!$this->nombre) {
            self::$alertas['error'][] = "Escribe un nombre para la receta";
        }

        if(!$this->observacion) {
            self::$alertas['error'][] = "Escribe un detalle para la receta";
        }

        return self::$alertas;
    }

        // Revisa si la categoria existe
        public function existeReceta() {
            // Query SQL. Se leen los datos de la DB.
            $query = "SELECT * FROM " . self::$tabla . " WHERE nombre = '" . $this->nombre . "' LIMIT 1";
                
            // Consulta SQL. Se guardan los datos en resultado
            $resultado = self::$db->query($query);
        
            // Si el usuario ya está registrado, se agrega a las alertas
            if($resultado->num_rows) {
                self::$alertas['error'][] = 'La receta ya existe';
            }
    
            // Retorna el resultado
            return $resultado;
        }


}