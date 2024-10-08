<?php

namespace Model;

class Producto extends ActiveRecord {

    // Tabla
    protected static $tabla = 'producto';

    // Columnas
    protected static $columnasDB = ['id', 'categoriaId', 'nombre', 'presentacion', 'cantidadPresentacion', 'medidaId', 'unidad_empaque', 'cantidad', 'totalMedida', 'precioUnidad', 'precioMedida', 'total', 'estado', 'imagen_nombre'];

    // Atributos
    public $id;
    public $categoriaId;
    public $nombre;
    public $presentacion;
    public $cantidadPresentacion;
    public $medidaId;
    public $unidad_empaque;
    public $cantidad;
    public $totalMedida;
    public $precioUnidad;
    public $precioMedida;
    public $total;
    public $estado;
    public $imagen_nombre;
    public $total_stock ;
    public $cantidad_vendida ;
    public $total_ingresos ;
    public $bodega;
    public $ultima_fecha_movimiento;


    // Constructor de atributos
    public function __construct($args = []){
        $this->id = $args['id'] ?? NULL ;
        $this->categoriaId = $args['categoriaId'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->presentacion = $args['presentacion'] ?? '';
        $this->cantidadPresentacion = $args['cantidadPresentacion'] ?? '';
        $this->medidaId = $args['medidaId'] ?? '';
        $this->unidad_empaque = $args['unidad_empaque'] ?? '';
        $this->cantidad = $args['cantidad'] ?? 0;
        $this->totalMedida = $args['totalMedida'] ?? 0;
        $this->precioUnidad = $args['precioUnidad'] ?? 0;
        $this->precioMedida = $args['precioMedida'] ?? 0;
        $this->total = $args['total'] ?? 0;
        $this->estado = $args['estado'] ?? '';
        $this->imagen_nombre = $args['imagen_nombre'] ?? null;
        $this->total_stock = $args['total_stock'] ?? null;
        $this->cantidad_vendida = $args['cantidad_vendida'] ?? null;
        $this->total_ingresos = $args['total_ingresos'] ?? null;
        $this->bodega = $args['bodega'] ?? null;
        $this->ultima_fecha_movimiento = $args['ultima_fecha_movimiento'] ?? null;
    }

    public function validar() {

        if(!$this->categoriaId) {
            self::$alertas['error'][] = "Selecciona una categoría";
        }

        if(!$this->nombre) {
            self::$alertas['error'][] = "El nombre del producto es obligatorio";
        }

        if(!$this->presentacion) {
            self::$alertas['error'][] = "La presentación del producto es obligatoria";
        }

        if(!$this->cantidadPresentacion) {
            self::$alertas['error'][] = "La cantidad de presentación del producto es obligatoria";
        }

        if(!$this->medidaId) {
            self::$alertas['error'][] = "La unidad de medida del producto es obligatoria";
        }

        if(!$this->unidad_empaque) {
            self::$alertas['error'][] = "La unidad o empaque es obligatoria";
        }

        if(!$this->cantidad) {
            self::$alertas['error'][] = "La cantidad de unidades por empaque es obligatoria";
        }

        // if(!$this->totalMedida) {
        //     self::$alertas['error'][] = "La medida total del producto es obligatorio";
        // }

        // if(!$this->precioUnidad) {
        //     self::$alertas['error'][] = "El precio del producto es obligatorio";
        // }

        // if(!$this->precioMedida) {
        //     self::$alertas['error'][] = "El precio por medida del producto es obligatorio";
        // }

        if(!$this->estado) {
            self::$alertas['error'][] = "El estado de producto es obligatorio";
        }

        

        return self::$alertas;
    }



}