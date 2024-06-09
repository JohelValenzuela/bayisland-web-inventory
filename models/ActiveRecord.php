<?php
namespace Model;

#[\AllowDynamicProperties]
class ActiveRecord {

    

    // BASE DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];


    // Visibilidad de los atributos
    public $id, $nombre, $apellido, $confirmado, $correo, $rolId, $token, $cantidad, $volumen, $contenido, $categoriaId, $presentacion, $medidaId, $unidad_empaque, $estado, $cantidadPresentacion, $categoria, $medida, $referencia, $producto, $observacion, $usuario, $fechaCreacion, $precioUnidad, $precioMedida, $totalMedida, $productoId, $usuarioId, $cantidadTotal, $cantidadAnterior, $usuarioIdAprueba, $maestroId, $movimiento, $recetaId, $producto_id, $receta_id, $cliente, $usuario_id, $codigo_brazalete, $receta, $guia1_id, $guia2_id, $guia3_id, $guia4_id, $guia5_id, $guia_muelle_id, $reportado_por_id, $capitan_id;

    




    // Mensajes y Alertas 
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    public static function getAlertas() {
        return static::$alertas;
    }

    // Validación
    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);
        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        //debug($array);
        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    //Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        //debug($sanitizado);
        return $sanitizado; 
    } 


    // public function sanitizarAtributos() {
    //     $atributos = $this->atributos();
    //     $sanitizado = [];
    //     foreach ($atributos as $key => $value) {
    //         // Verificar si el valor es un array
    //         if (is_array($value)) {
    //             // Convertir el array a una cadena de texto
    //             $value = implode(', ', $value);
    //         }
    //         // Convertir el valor a un entero si es posible
    //         $value = is_numeric($value) ? intval($value) : strval($value);
    //         // Escapar el valor y asignarlo al array sanitizado
    //         $sanitizado[$key] = self::$db->escape_string($value);
    //     }
    //     //debug($sanitizado);
    //     return $sanitizado;
    // }
    
    


    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

/* REGISTROS - CRUD  */

    // Guardar
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // Llamar todos los registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function allLimitado($limite) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT {$limite}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function allSearch($nombre) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE nombre LIKE '%{$nombre}%'";
        //debug($query);
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function allNombre($usuarioId) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE usuarioId = {$usuarioId}";
        //debug($query);
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = {$id}";
        //debug($query);
        $resultado = self::consultarSQL($query);
        //var_dump($resultado);
        return array_shift( $resultado ) ;
    }

    public static function findVentaPorCliente($cliente_id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE cliente = {$cliente_id}";
        //debug($query);
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    public static function findVentasPorCliente($cliente_id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE cliente = " . intval($cliente_id);
        //var_dump($query);
        $resultado = self::consultarSQL($query);
        //var_dump($resultado);
        return $resultado;
    }
    

    public static function findMaestro($id) {
        $query = "SELECT * FROM maestro_pedido WHERE id = {$id}";
        //debug($query);
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    public static function findStock($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE productoId = {$id}";
        //debug($query);
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    public static function findReceta($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE recetaId = {$id}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function findReferencia($referencia) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE referencia = '{$referencia}'";
        //debug($query);
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function findReferenciaGuarda($estado, $observacion, $referencia) {
        $query = "UPDATE " . static::$tabla  ." 
                SET estado = '{$estado}', observacion = '{$observacion}'
                WHERE referencia = '{$referencia}'";

        //debug($query);
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public static function findProducto($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE productoId = {$id}";
        //debug($query);
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    public static function findCliente($codigo,) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE cliente = {$codigo}";
        //debug($query);
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function findVenta($codigo,) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE venta_id = {$codigo}";
        //debug($query);
        $resultado = self::consultarSQL($query);
        //debug($resultado);
        return array_shift($resultado);
    }

    public static function findVentas($venta_id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE venta_id = " . intval($venta_id);
        //debug($query);
        $resultado = self::consultarSQL($query);
        //var_dump($resultado);
        return $resultado ? array_shift($resultado) : null;
    }
    

    public static function findVentaRegistros($codigo,) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE venta_id = {$codigo}";
        //debug($query);
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function findBrazalete($codigo,) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE codigo_brazalete = {$codigo}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function findRegistro($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE productoId = {$id} ORDER BY id DESC LIMIT 1";
        //debug($query);
        $resultado = self::consultarSQL($query);
        return array_shift($resultado) ;
    }

    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE {$columna} = '{$valor}'";
        //debug($query);
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    public static function paginar($por_pagina, $offset) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT {$por_pagina} OFFSET {$offset}";
        //debug($query);
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function paginarBusqueda($por_pagina, $offset, $busqueda) {
        $query = "SELECT * FROM " . static::$tabla ." WHERE categoriaId LIKE '%{$busqueda}%' OR nombre LIKE '%{$busqueda}%' 
                                                        OR presentacion LIKE '%{$busqueda}%' OR unidad_empaque LIKE '%{$busqueda}%' 
                                                        OR cantidad LIKE '%{$busqueda}%' OR medidaId LIKE '%{$busqueda}%'
                                                        LIMIT {$por_pagina} OFFSET {$offset}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function contar($busqueda) {
        $query = "SELECT COUNT(*) FROM " . static::$tabla ." WHERE categoriaId LIKE '%{$busqueda}%' OR nombre LIKE '%{$busqueda}%' 
                                                        OR presentacion LIKE '%{$busqueda}%' OR unidad_empaque LIKE '%{$busqueda}%' 
                                                        OR cantidad LIKE '%{$busqueda}%' OR medidaId LIKE '%{$busqueda}%'";
    $resultado = self::$db->query($query);
    $contar = $resultado->fetch_array();
    return array_shift ($contar);
    }
    
    public static function cuentaCantidad() {
        $query = "SELECT COUNT(*) FROM " . static::$tabla;
        $resultado = self::$db->query($query);
        $cuentaCantidad = $resultado->fetch_array();
        return  array_shift ($cuentaCantidad);
    }
    
    public static function cuentaDistintos($columna) {
        $query = "SELECT COUNT(distinct {$columna}) FROM " . static::$tabla;
        $resultado = self::$db->query($query);
        $cuentaCantidad = $resultado->fetch_array();
        return  array_shift ($cuentaCantidad);
    }

    public static function cuentaCantidadEstado($columna, $busqueda) {
        $query = "SELECT COUNT(*) FROM " . static::$tabla . " WHERE {$columna} = '{$busqueda}'";
        $resultado = self::$db->query($query);
        $cuentaCantidadEstado = $resultado->fetch_array();
        return  array_shift ($cuentaCantidadEstado);
    }

    public static function calculoCantidad($tabla, $columna, $valor1, ) {
        $query = "SELECT cantidad FROM {$tabla} WHERE {$columna} = {$valor1}";
        $resultado = self::consultarSQL($query);
        return  array_shift ($resultado);
    }

    public static function calcularCantidad($valor1, $tabla, $columna) {
        $query = "SELECT cantidadTotal FROM {$tabla} WHERE {$columna} = {$valor1}";
        $resultado = self::consultarSQL($query);
        return  array_shift ($resultado);
    }

    public static function stockDisponible($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla .  " WHERE {$columna} <= {$valor}";
        //debug($query);
        $resultado = self::consultarSQL($query);
        return  array_shift ($resultado);
    }

    public static function total() {
        $query = "SELECT COUNT(*) FROM " . static::$tabla;
        $resultado = self::$db->query($query);
        $total_registros = $resultado->fetch_array();
        return array_shift ($total_registros);
    }


    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT {$limite}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Crea un nuevo registro
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        //debug($atributos);
        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('"; 
        $query .= join("', '", array_values($atributos));
        $query .= "') ";
        //debug($query);
        // Resultado de la consulta
        $resultado = self::$db->query($query);
        //debug($resultado);
        
        return [
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id
        ];
    }

    public function crearReportePasajero() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        
        // Preparar las claves y valores para la inserción
        $claves = [];
        $valores = [];
        foreach ($atributos as $clave => $valor) {
            $claves[] = $clave;
            // Si el valor es NULL, usar NULL en la consulta SQL
            if ($valor === "") {
                $valores[] = "NULL";
            } else {
                $valores[] = "'" . self::$db->real_escape_string($valor) . "'";
            }
        }
        //debug($valores);
        // Construir la consulta SQL
        $query = "INSERT INTO " . static::$tabla . " (";
        $query .= implode(', ', $claves);
        $query .= ") VALUES (";
        $query .= implode(', ', $valores);
        $query .= ")";
        //debug($query);
        // Ejecutar la consulta SQL
        $resultado = self::$db->query($query);

        // Retornar el resultado y el ID del nuevo registro insertado
        return [
        'resultado' =>  $resultado,
        'id' => self::$db->insert_id
        ];
    }

    // Actualizar el registro
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        //debug($atributos);

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        //debug($query);

        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }



    // Eliminar un Registro por su ID
    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        //debug($query);
        $resultado = self::$db->query($query);
        return $resultado;
    }

}