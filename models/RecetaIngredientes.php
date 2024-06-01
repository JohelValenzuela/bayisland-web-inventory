<?php

namespace Model;

class RecetaIngredientes extends ActiveRecord {

    // Tabla
    protected static $tabla = 'receta_ingredientes';

    // Columnas
    protected static $columnasDB = ['id', 'recetaId', 'productoId', 'cantidad'];

    // Atributos
    public $id;
    public $recetaId;
    public $productoId;
    public $cantidad;


    // Constructor de atributos
    public function __construct($args = []){
        $this->id = $args['id'] ?? NULL ;
        $this->recetaId = $args['recetaId'] ?? '';
        $this->productoId = $args['productoId'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
    }

    public function validar() {


        if(!$this->recetaId) {
            self::$alertas['error'][] = "Selecciona una receta";
        }

        if(!$this->productoId) {
            self::$alertas['error'][] = "Selecciona un producto";
        }

        if(!$this->cantidad) {
            self::$alertas['error'][] = "Ingresa la cantidad de producto necesario para la receta";
        }

        return self::$alertas;
    }



}