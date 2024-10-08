<?php

namespace Model;

class ReportePasajero extends ActiveRecord {
    protected static $tabla = 'reporte_pasajeros';
    protected static $columnasDB = ['id', 'fecha', 'guia1_id', 'guia1_pasajeros', 'guia2_id', 'guia2_pasajeros', 'guia3_id', 'guia3_pasajeros', 'guia4_id', 'guia4_pasajeros', 'guia5_id', 'guia5_pasajeros', 'pasajeros_muelle', 'pasajeros_no_show', 'reportado_por_id', 'guias_bote_ids', 'capitan_id', 'guia_muelle_id'];

    public $id;
    public $fecha;
    public $guia1_id;
    public $guia1_pasajeros;
    public $guia2_id;
    public $guia2_pasajeros;
    public $guia3_id;
    public $guia3_pasajeros;
    public $guia4_id;
    public $guia4_pasajeros;
    public $guia5_id;
    public $guia5_pasajeros;
    public $pasajeros_muelle;
    public $pasajeros_no_show;
    public $reportado_por_id;
    public $guias_bote_ids;
    public $capitan_id;
    public $guia_muelle_id;
    public $guia1;
    public $guia2;
    public $guia3;
    public $guia4;
    public $guia5;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? date('Y-m-d H:i:s');
        $this->guia1_id = $args['guia1_id'] ?? null;
        $this->guia1_pasajeros = $args['guia1_pasajeros'] ?? 0;
        $this->guia2_id = $args['guia2_id'] ?? null;
        $this->guia2_pasajeros = $args['guia2_pasajeros'] ?? 0;
        $this->guia3_id = $args['guia3_id'] ?? null;
        $this->guia3_pasajeros = $args['guia3_pasajeros'] ?? 0;
        $this->guia4_id = $args['guia4_id'] ?? null;
        $this->guia4_pasajeros = $args['guia4_pasajeros'] ?? 0;
        $this->guia5_id = $args['guia5_id'] ?? null;
        $this->guia5_pasajeros = $args['guia5_pasajeros'] ?? 0;
        $this->pasajeros_muelle = $args['pasajeros_muelle'] ?? 0;
        $this->pasajeros_no_show = $args['pasajeros_no_show'] ?? 0;
        $this->reportado_por_id = $args['reportado_por_id'] ?? null;
        $this->guias_bote_ids = $args['guias_bote_ids'] ?? '';
        $this->capitan_id = $args['capitan_id'] ?? null;
        $this->guia_muelle_id = $args['guia_muelle_id'] ?? null;
        $this->guia1 = $args['guia1'] ?? 0;
        $this->guia2 = $args['guia2'] ?? 0;
        $this->guia3 = $args['guia3'] ?? 0;
        $this->guia4 = $args['guia4'] ?? 0;
        $this->guia5 = $args['guia5'] ?? 0;
    }

    public function validar() {

        if (!$this->guia1_id) {
            self::$alertas['error'][] = 'Debes seleccionar o ingresar almenos un guía';
        }

        if (!$this->guia1_pasajeros) {
            self::$alertas['error'][] = 'Debes ingresar almenos una cantidad de pasajeros';
        }

        if (!$this->guia_muelle_id) {
            self::$alertas['error'][] = 'Debes seleccionar o ingresar un guía en muelle';
        }

        if (!$this->pasajeros_muelle) {
            self::$alertas['error'][] = 'Debes ingresar la cantidad de pasajeros en muelle';
        }

        if (!$this->pasajeros_no_show) {
            self::$alertas['error'][] = 'Debes ingresar la cantidad de pasajeros no show';
        }

        if (!$this->reportado_por_id) {
            self::$alertas['error'][] = 'Debes seleccionar o ingresar el usuario que reporta';
        }

        if (!$this->capitan_id) {
            self::$alertas['error'][] = 'Debes seleccionar o ingresar un capitán de bote';
        }

        return self::$alertas;
    }

    // Método para agregar una propiedad dinámica
    public function __set($nombre, $valor) {
        $this->$nombre = $valor;
    }

    // Método para obtener una propiedad dinámica
    public function __get($nombre) {
        return $this->$nombre;
    }
    
}
