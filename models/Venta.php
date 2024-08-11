<?php

namespace Model;

class Venta extends ActiveRecord {
    protected static $tabla = 'ventas';
    protected static $columnasDB = ['id', 'cliente', 'fecha', 'usuario_id'];

    public $id;
    public $cliente;
    public $fecha;
    public $usuario_id;
    public $montoTotal;
    public $cantidadVentas;
    public $cantidadProductos;
    public $cantidad_ventas;
    public $monto_total;
    public $mes;
    public $total_ingresos;
    public $cantidad_vendida;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->cliente = $args['cliente'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
        $this->usuario_id = $args['usuario_id'] ?? null;
        $this->montoTotal = $args['montoTotal'] ?? 0;
        $this->cantidadProductos = $args['cantidadProductos'] ?? 0;
        $this->cantidad_ventas = $args['cantidad_ventas'] ?? 0;
        $this->monto_total = $args['monto_total'] ?? 0;
        $this->mes = $args['mes'] ?? 0;
        $this->cantidad_vendida = $args['cantidad_vendida'] ?? 0;
    }

    public function validar() {
        if (!$this->cliente) {
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

    // Método para agregar una propiedad dinámica
    public function __set($nombre, $valor) {
        $this->$nombre = $valor;
    }

    // Método para obtener una propiedad dinámica
    public function __get($nombre) {
        return $this->$nombre;
    }
}
