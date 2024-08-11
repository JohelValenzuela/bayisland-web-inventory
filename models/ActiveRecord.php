<?php
namespace Model;

#[\AllowDynamicProperties]
class ActiveRecord {

    

    // BASE DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];


    // Visibilidad de los atributos
    public $id, $nombre, $apellido, $confirmado, $correo, $rolId, $token, $cantidad, $volumen, $contenido, $categoriaId, $presentacion, $medidaId, $unidad_empaque, $estado, $cantidadPresentacion, $categoria, $medida, $referencia, $producto, $observacion, $usuario, $fechaCreacion, $precioUnidad, $precioMedida, $totalMedida, $productoId, $usuarioId, $cantidadTotal, $cantidadAnterior, $usuarioIdAprueba, $maestroId, $movimiento, $recetaId, $producto_id, $receta_id, $cliente, $usuario_id, $codigo_brazalete, $receta, $guia1_id, $guia2_id, $guia3_id, $guia4_id, $guia5_id, $guia_muelle_id, $reportado_por_id, $capitan_id, $fecha, $guia1_pasajeros, $guia2_pasajeros, $guia3_pasajeros, $guia4_pasajeros, $guia5_pasajeros, $pasajeros_muelle, $reportado_por, $guias_bote_ids, $pasajeros_no_show, $bodegaId, $ubicacion;

    




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

    public static function porUsuario($usuarioId) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE usuario_id = {$usuarioId}";
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

    public static function findVentaProductos($id) {
        $query = "SELECT * FROM venta_productos WHERE venta_id = {$id}";
        //debug($query);
        $resultado = self::consultarSQL($query);
        //var_dump($resultado);
        return $resultado ;
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

    public static function findStockBodega($id, $bodegaId) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE productoId = {$id} && bodegaId = {$bodegaId} ORDER BY id DESC LIMIT 1";
        //debug($query);
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    public static function findIngredientesReceta($receta_id) {
        $query = "SELECT * FROM receta_ingredientes WHERE recetaId = {$receta_id}";
        //debug($query);
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    

    public static function findDetallePedido($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE maestroId = {$id}";
        //debug($query);
        $resultado = self::consultarSQL($query);
        return $resultado;
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
        return $resultado;
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
        debug($query);
        $resultado = self::$db->query($query);
        return $resultado;
    }






    /*** GRAFICOS */

    public static function graficoVentasPorDia() {
        $query = "SELECT DATE(fecha) AS fecha, COUNT(*) AS cantidadVentas, SUM(vp.cantidad) AS cantidadProductos, SUM(vp.precio * vp.cantidad) AS montoTotal
                  FROM ventas v
                  JOIN venta_productos vp ON v.id = vp.venta_id
                  GROUP BY DATE(fecha)
                  ORDER BY Fecha";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    
    public static function graficoVentasPorProducto() {
        $query = "SELECT p.nombre AS producto, COUNT(*) AS cantidadVentas, SUM(vp.cantidad) AS cantidadTotal, SUM(vp.precio * vp.cantidad) AS montoTotal
                  FROM ventas v
                  JOIN venta_productos vp ON v.id = vp.venta_id
                  JOIN producto p ON vp.producto_id = p.id
                  GROUP BY p.nombre
                  ORDER BY cantidadVentas DESC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function reporteVentasPorProducto() {
        $query = "SELECT p.nombre AS producto, 
                         SUM(v.cantidad) AS cantidad_ventas, 
                         SUM(v.precio) AS monto_total
                  FROM venta_productos v
                  JOIN producto p ON v.producto_id = p.id
                  GROUP BY p.nombre";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    

    // Reporte de Ventas por Cliente
    public static function reporteVentasPorCliente() {
        $query = "SELECT c.nombre AS cliente, v.fecha AS fecha, vp.producto_id AS producto, vp.cantidad AS cantidad, vp.precio AS precio
                FROM ventas v
                JOIN clientes c ON v.cliente = c.id
                JOIN venta_productos vp ON v.id = vp.venta_id
                ORDER BY v.fecha";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Reporte de Cobros por Cliente
    public static function reporteCobrosPorCliente() {
        $query = "SELECT 
                c.nombre AS cliente,
                co.metodo_pago AS metodo_pago,
                SUM(co.cantidad_pagada) AS cantidad_pagada,
                MAX(co.fecha_registro) AS ultima_fecha
                FROM  cobros co
                JOIN  clientes c ON co.cliente_id = c.id
                GROUP BY  c.nombre, co.metodo_pago
                ORDER BY ultima_fecha DESC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Reporte de Stock por Producto y Bodega
    public static function reporteStockPorProductoYBodega() {
        $query = "SELECT p.nombre AS producto, b.nombre AS bodega, s.cantidad AS cantidad, s.movimiento AS movimiento, s.fechaCreacion AS fecha
                FROM stock s
                JOIN producto p ON s.productoId = p.id
                JOIN bodegas b ON s.bodegaId = b.id
                ORDER BY s.fechaCreacion";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Reporte de Pedidos por Usuario
    public static function reportePedidosPorUsuario() {
        $query = "SELECT 
        u.nombre AS usuario, 
        COUNT(mp.id) AS cantidad_pedidos
        FROM maestro_pedido mp
        JOIN usuarios u ON mp.usuarioId = u.id
        GROUP BY  u.nombre
        ORDER BY cantidad_pedidos DESC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Reporte de Productos Más Vendidos
    public static function reporteProductosMasVendidos() {
        $query = "SELECT p.nombre AS producto, SUM(vp.cantidad) AS cantidad_vendida, SUM(vp.precio * vp.cantidad) AS total_ingresos
                FROM venta_productos vp
                JOIN producto p ON vp.producto_id = p.id
                GROUP BY p.nombre
                ORDER BY cantidad_vendida DESC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Reporte de Kardex por Producto y Bodega
    public static function reporteKardexPorProductoYBodega() {
        $query = "SELECT p.nombre AS producto, b.nombre AS bodega, k.referencia AS referencia, k.cantidadEntrada AS entrada, k.cantidadSalida AS salida, k.cantidadTotal AS total, k.fechaCreacion AS fecha
                FROM kardex k
                JOIN producto p ON k.productoId = p.id
                JOIN bodegas b ON k.bodegaId = b.id
                ORDER BY k.fechaCreacion";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Reporte de Clientes con Deuda
    public static function reporteClientesConDeuda() {
        $query = "SELECT c.nombre AS cliente, SUM(co.debe) AS total_deuda
                FROM cobros co
                JOIN clientes c ON co.cliente_id = c.id
                WHERE co.estado = 'pendiente'
                GROUP BY c.nombre
                ORDER BY total_deuda DESC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }


    // Reporte de Defectos por Producto y Bodega
    // public static function reporteDefectosPorProductoYBodega() {
    //     $query = "SELECT p.nombre AS producto, b.nombre AS bodega, rd.cantidad AS cantidad, rd.observacion AS observacion, rd.fecha_reporte AS fecha
    //             FROM reportes_defectos rd
    //             JOIN producto p ON rd.producto_id = p.id
    //             JOIN bodegas b ON rd.bodegaId = b.id
    //             ORDER BY rd.fecha_reporte";
    //     $resultado = self::consultarSQL($query);
    //     return $resultado;
    // }

    // // Reporte de Regalias por Producto y Bodega
    // public static function reporteRegaliasPorProductoYBodega() {
    //     $query = "SELECT p.nombre AS producto, b.nombre AS bodega, r.cantidad AS cantidad, r.observacion AS observacion, r.fecha_regalia AS fecha
    //             FROM regalias r
    //             JOIN producto p ON r.producto_id = p.id
    //             JOIN bodegas b ON r.bodegaId = b.id
    //             ORDER BY r.fecha_regalia";
    //     $resultado = self::consultarSQL($query);
    //     return $resultado;
    // }

    // Reporte de Defectos por Producto y Bodega
    public static function reporteDefectosPorBodega() {
        $query = "SELECT b.nombre AS bodega, COUNT(rd.id) AS cantidad_defectos
                  FROM reportes_defectos rd
                  JOIN bodegas b ON rd.bodegaId = b.id
                  GROUP BY b.nombre
                  ORDER BY b.nombre";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Reporte de Regalias por Producto y Bodega
    public static function reporteRegaliasPorBodega() {
        $query = "SELECT b.nombre AS bodega, COUNT(r.id) AS cantidad_regalias
                FROM regalias r
                JOIN bodegas b ON r.bodegaId = b.id
                GROUP BY b.nombre
                ORDER BY cantidad_regalias DESC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }


    // Reporte de Pasajeros por Guía
    public static function reportePasajerosPorGuia() {
        $query = "SELECT r.fecha AS fecha, g1.nombre AS guia1, r.guia1_pasajeros AS pasajeros_guia1, g2.nombre AS guia2, r.guia2_pasajeros AS pasajeros_guia2, g3.nombre AS guia3, r.guia3_pasajeros AS pasajeros_guia3, g4.nombre AS guia4, r.guia4_pasajeros AS pasajeros_guia4, g5.nombre AS guia5, r.guia5_pasajeros AS pasajeros_guia5
                FROM reporte_pasajeros r
                LEFT JOIN guias g1 ON r.guia1_id = g1.id
                LEFT JOIN guias g2 ON r.guia2_id = g2.id
                LEFT JOIN guias g3 ON r.guia3_id = g3.id
                LEFT JOIN guias g4 ON r.guia4_id = g4.id
                LEFT JOIN guias g5 ON r.guia5_id = g5.id
                ORDER BY r.fecha";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Reporte de Ventas por Mes
    public static function reporteVentasPorMes() {
        $query = "SELECT DATE_FORMAT(v.fecha, '%Y-%m') AS mes, SUM(vp.cantidad) AS cantidad_vendida, SUM(vp.precio * vp.cantidad) AS total_ingresos
                FROM ventas v
                JOIN venta_productos vp ON v.id = vp.venta_id
                GROUP BY DATE_FORMAT(v.fecha, '%Y-%m')
                ORDER BY mes";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Reporte de Clientes Frecuentes
    public static function reporteClientesFrecuentes() {
        $query = "SELECT c.nombre AS cliente, COUNT(v.id) AS total_compras, SUM(vp.cantidad) AS total_productos, SUM(vp.precio * vp.cantidad) AS total_gastado
                FROM clientes c
                JOIN ventas v ON c.id = v.cliente
                JOIN venta_productos vp ON v.id = vp.venta_id
                GROUP BY c.nombre
                HAVING COUNT(v.id) > 5
                ORDER BY total_gastado DESC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Reporte de Productos con Mayor Stock
    public static function reporteProductosConMayorStock() {
        $query = "SELECT p.nombre AS producto, SUM(s.cantidad) AS total_stock
                FROM producto p
                JOIN stock s ON p.id = s.productoId
                GROUP BY p.nombre
                ORDER BY total_stock DESC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Reporte de Productos Sin Movimiento
    // public static function reporteProductosSinMovimiento() {
    //     $query = "SELECT p.nombre AS producto, MAX(s.fechaCreacion) AS ultima_fecha_movimiento
    //             FROM producto p
    //             LEFT JOIN stock s ON p.id = s.productoId
    //             GROUP BY p.nombre
    //             HAVING MAX(s.fechaCreacion) < DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    //             ORDER BY ultima_fecha_movimiento DESC";
    //     $resultado = self::consultarSQL($query);
    //     return $resultado;
    // }

    // public static function reporteProductosSinMovimiento() {
    //     $query = "SELECT 
    //             p.nombre AS producto,
    //             s.bodegaId AS bodega,
    //             MAX(s.fechaCreacion) AS ultima_fecha_movimiento
    //             FROM producto p
    //             LEFT JOIN stock s ON p.id = s.productoId
    //             GROUP BY p.nombre, s.bodegaId
    //             HAVING MAX(s.fechaCreacion) < DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
    //             ORDER BY ultima_fecha_movimiento DESC;";
    //     $resultado = self::consultarSQL($query);
    //     return $resultado;
    // }

    public static function reporteProductosSinMovimiento() {
        $query = "SELECT 
        p.nombre AS producto,
        s.bodegaId AS bodega,
        MAX(s.fechaCreacion) AS ultima_fecha_movimiento
    FROM 
        producto p
    LEFT JOIN 
        stock s ON p.id = s.productoId
    GROUP BY 
        p.nombre, s.bodegaId
    HAVING 
        MAX(s.fechaCreacion) < DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
    ORDER BY 
        ultima_fecha_movimiento DESC;
    ";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    

    // Reporte de Ventas por Categoría de Producto
    public static function reporteVentasPorCategoriaDeProducto() {
        $query = "SELECT cat.nombre AS categoria, SUM(vp.cantidad) AS cantidad_vendida, SUM(vp.precio * vp.cantidad) AS total_ingresos
                FROM producto p
                JOIN categoria cat ON p.categoriaId = cat.id
                JOIN venta_productos vp ON p.id = vp.producto_id
                GROUP BY cat.nombre
                ORDER BY total_ingresos DESC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Reporte de Productos Devueltos por Cliente
    // public static function reporteProductosDevueltosPorCliente() {
    //     $query = "SELECT c.nombre AS cliente, p.nombre AS producto, d.cantidad AS cantidad_devuelta, d.fecha AS fecha
    //               FROM devoluciones d
    //               JOIN clientes c ON d.cliente_id = c.id
    //               JOIN producto p ON d.producto_id = p.id
    //               ORDER BY d.fecha";
    //     $resultado = self::consultarSQL($query);
    //     return $resultado;
    // }

    // Reporte de Ingresos y Egresos por Bodega
    public static function reporteIngresosYEgresosPorBodega() {
        $query = "SELECT b.nombre AS bodega,
                        SUM(CASE WHEN s.movimiento = 'entrada' THEN s.cantidad ELSE 0 END) AS total_ingresos,
                        SUM(CASE WHEN s.movimiento = 'salida' THEN s.cantidad ELSE 0 END) AS total_egresos
                FROM stock s
                JOIN bodegas b ON s.bodegaId = b.id
                GROUP BY b.nombre
                ORDER BY b.nombre";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Reporte de Ventas por Usuario
    public static function reporteVentasPorUsuario() {
        // Consulta SQL para obtener ventas totales por usuario
        $query = "SELECT
            u.nombre AS usuario,
            COALESCE(SUM(vp.precio * vp.cantidad), 0) AS total_ventas
        FROM ventas v
        JOIN venta_productos vp ON v.id = vp.venta_id
        JOIN usuarios u ON v.usuario_id = u.id
        GROUP BY u.id
        ORDER BY total_ventas DESC";
    
        $resultado = self::$db->query($query);
    
        $resultados = [];
        while ($fila = $resultado->fetch_assoc()) {
            $registro = new self();
            $registro->usuario = $fila['usuario']; // Usa el nombre del usuario en lugar del ID
            $registro->total_ventas = $fila['total_ventas']; // Usa la propiedad dinámica
            $resultados[] = $registro;
        }
        return $resultados;
    }
    

    
    //Reporte de Pasajeros por Día
    public static function obtenerPasajerosPorDia() {
        $query = "SELECT fecha, (guia1_pasajeros + guia2_pasajeros + guia3_pasajeros + guia4_pasajeros + guia5_pasajeros) AS total_pasajeros FROM reporte_pasajeros";
        $resultado = self::$db->query($query);
    
        $resultados = [];
        while ($fila = $resultado->fetch_assoc()) {
            $registro = new self();
            $registro->fecha = $fila['fecha'];
            $registro->total_pasajeros = $fila['total_pasajeros'];
            $resultados[] = $registro;
        }
        return $resultados;
    }
    



}