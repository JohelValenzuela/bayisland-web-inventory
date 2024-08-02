<?php
use Model\Cliente;
use Model\Cobro;
use Model\Inventario;
use Model\Kardex;
use Model\MaestroPedido;
use Model\Producto;
use Model\Regalia;
use Model\ReporteDefecto;
use Model\ReportePasajero;
use Model\Stock;
use Model\Venta;
use Model\VentaProductos;
use Model\VentaUltimaHora;
?>

<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text"> Dashboard</span>
    </div>

    <form action="/dashboard" class="form form-contenido form-dashboard" method="POST" enctype="multipart/form-data">
      
            <div class="cardline-flex">
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon rojo">
                        <a href="categoria">
                        <i class='bx bx-collection'></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Categorías</div>
                            <div class="card-contador"><?php
                                echo strval($categoriaDash); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon azul">
                        <a href="producto">
                            <i class='bx bx-package' ></i>
                        </a>                       
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Productos</div>
                            <div class="card-contador"><?php echo strval($productoDash); ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon teal">
                        <a href="pedido">
                            <i class='bx bx-cart'></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Ordenes de compra</div>
                            <div class="card-contador"><?php echo strval($pedidoDash) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon azulClaro">
                        <a href="stock">
                            <i class='bx bx-box' ></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Productos en Stock</div>
                            <div class="card-contador"><?php echo strval($stockDash) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon verdeAgua">
                        <a href="ventas">
                            <i class='bx bx-box' ></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Ventas</div>
                            <div class="card-contador"><?php echo strval($ventasDash) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon morado">
                        <a href="ventas_ultima_hora">
                            <i class='bx bx-box' ></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Ventas Extra</div>
                            <div class="card-contador"><?php echo strval($ventas_ultimaDash) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon rosaOscuro">
                        <a href="recetas/mostrar">
                            <i class='bx bx-food-menu'></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Recetas</div>
                            <div class="card-contador"><?php echo strval($recetasDash) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon naranja">
                        <a href="recetas/mostrar">
                            <i class='bx bx-fridge' ></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Ingredientes</div>
                            <div class="card-contador"><?php echo strval($ingredientesDash) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon rojo">
                        <a href="inventario">
                            <i class='bx bx-history'></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Registros en Kardex</div>
                            <div class="card-contador"><?php echo strval($inventarioDash) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon azul">
                        <a href="auth/mostrar">
                            <i class='bx bx-user' ></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Usuarios</div>
                            <div class="card-contador"><?php echo strval($usuarioDash) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon teal">
                        <a href="medida">
                            <i class='bx bx-ruler'></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Medidas</div>
                            <div class="card-contador"><?php echo strval($medidasDash) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon azulClaro">
                        <a href="reportesDefectos">
                            <i class='bx bx-repost'></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Reporte de Daños</div>
                            <div class="card-contador"><?php echo strval($defectosDash) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon verdeAgua">
                        <a href="regalias">
                            <i class='bx bx-gift' ></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Reporte de Regalías</div>
                            <div class="card-contador"><?php echo strval($regaliasDash) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon morado">
                        <a href="pasajeros">
                            <i class='bx bx-bus'></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Reporte de Pasajeros</div>
                            <div class="card-contador"><?php echo strval($pasajerosDash) ?></div>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="card-tabla-flex">
                <!-- Reporte 1: Ventas por Día -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Ventas por Día</h3>
                        <div class="contenedor-tabla">
                            <canvas id="ventasPorDiaChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 2: Ventas por Producto -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Ventas por Producto</h3>
                        <div class="contenedor-tabla">
                        <canvas id="ventasPorProductoChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 3: Cobros por Cliente -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Cobros por Cliente</h3>
                        <div class="contenedor-tabla">
                            <canvas id="cobrosPorClienteChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 4: Stock por Producto y Bodega -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Stock por Producto y Bodega</h3>
                        <div class="contenedor-tabla">
                            <canvas id="stockPorProductoYBodegaChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 5: Pedidos por Usuario -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Pedidos por Usuario</h3>
                        <div class="contenedor-tabla">
                            <canvas id="pedidosPorUsuarioChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 6: Productos Vendidos -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Productos Vendidos</h3>
                        <div class="contenedor-tabla">
                            <canvas id="productosVendidosChart"></canvas>
                        </div>
                    </div>
                </div>
                 <!-- Reporte 7: Kardex de Productos -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Kardex de Productos</h3>
                        <div class="contenedor-tabla">
                            <canvas id="kardexProductosChart"></canvas>
                        </div>
                    </div>
                </div>
                 <!-- Reporte 8: Deudas por Cliente -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Deudas por Cliente</h3>
                        <div class="contenedor-tabla">
                            <canvas id="deudasPorClienteChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 9: Productos con Defectos -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Productos con Defectos</h3>
                        <div class="contenedor-tabla">
                            <canvas id="productosDefectosChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 10: Productos con Regalías -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Productos con Regalías</h3>
                        <div class="contenedor-tabla">
                            <canvas id="productosRegaliasChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 11: Pasajeros por Guía -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Pasajeros por Guía</h3>
                        <div class="contenedor-tabla">
                            <canvas id="pasajerosPorGuiaChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 12: Ventas por Mes -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Ventas por Mes</h3>
                        <div class="contenedor-tabla">
                            <canvas id="ventasPorMesChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 13: Clientes Frecuentes -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Clientes Frecuentes</h3>
                        <div class="contenedor-tabla">
                            <canvas id="clientesFrecuentesChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 14: Productos con Mayor Stock -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Productos con Mayor Stock</h3>
                        <div class="contenedor-tabla">
                            <canvas id="productosMayorStockChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 15: Productos sin Movimiento -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Productos sin Movimiento</h3>
                        <div class="contenedor-tabla">
                            <canvas id="productosSinMovimientoChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 16: Ventas por Categoría -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Ventas por Categoría</h3>
                        <div class="contenedor-tabla">
                            <canvas id="ventasPorCategoriaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        
            <div class="card-tabla-flex">
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Registro de cantidad mínima</h3>
                        <div class="contenedor-tabla">
                            <table class="tabla" id="minimo">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Producto</th>
                                        <th>Presentación</th>
                                        <th>Cantidad</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach($stock as $stock) : ?>
                                        <?php if($stock->cantidad <= 100) {
                                            if($stock->cantidad < 30){
                                                $clase = 'cantidad min';
                                            } else if($stock->cantidad > 30){
                                                $clase = 'cantidad med';
                                            }?>
                                        
                                            <tr>
                                                <td data-titulo="Id"><?php echo $stock->id; ?></td> <!--  ID  -->
                                                <td data-titulo="Nombre"><?php echo $stock->producto->nombre?></td> <!--  Nombre  -->
                                                <td data-titulo="Presentación"><?php echo $stock->producto->presentacion;?></td> <!--  Presentación  -->
                                                <td data-titulo="Cantidad">
                                                    <a class="<?php echo $clase?>">
                                                        <?php echo $stock->cantidad; ?>
                                                    </a>
                                                </td> <!--  Cantidad -->   
                                                <td>
                                                    <div class="acciones-tabla">
                                                        <a class="boton-accion entrada" href="/stock/entradaStock?id=<?php echo $stock->id; ?>">
                                                        <i class="fa-solid fa-eye"></i> Ver
                                                        </a>
                                                    </div>
                                                </td>                                                           
                                            </tr>
                                        <?php } ?>
                                        
                                    <?php endforeach; ?>
                                <tbody>
                            </table>
                        </div>
                        
                        <div class="form-botones final">
                            <a class="boton-exportar" href="stock"> Ver Stock</a>  
                        </div>
                    </div>
                </div>

                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Últimos movimientos</h3>
                        <div class="contenedor-tabla">
                            <table class="tabla" id="movimientos">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Referencia</th>
                                        <th>Producto</th>
                                        <th>Entrada</th>
                                        <th>Salida</th>
                                        <th>Cantidad Final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($inventario as $inventarios) : ?>
                                    <tr>
                                        <td data-titulo="Id"><?php echo $inventarios->id; ?></td> <!--  ID  -->
                                        <td data-titulo="Referencia"><?php echo $inventarios->referencia; ?></td> <!--  Referencia  -->
                                        <td data-titulo="Nombre"><?php echo $inventarios->producto->nombre; ?></td> <!--  Nombre  -->
                                        <td data-titulo="Entrada">  <?php echo $inventarios->cantidadEntrada; ?></td> <!--  Cantidad Entrada  -->
                                        <td data-titulo="Salida">  <?php echo $inventarios->cantidadSalida; ?></td> <!--  Cantidad Salida  -->
                                        <td data-titulo="Total"><?php echo $inventarios->cantidadTotal; ?></td> <!--  Cantidad Total  -->                                                    
                                    </tr>
                                    <?php endforeach; ?>
                                <tbody>
                            </table>
                        </div>
                        <div class="form-botones final">
                            <a class="boton-exportar" href="inventario">Ver Movimientos</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-tabla contenedor-pedidos">
                <div class="card-contenedor card-pedidos">
                    <h3>Pedidos Recientes</h3>
                    <div class="contenedor-tabla">
                        <table class="tabla" id="pedidos">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Referencia</th>
                                <th>Categoria</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Observacion</th>
                                <th>Estado</th>
                                <th>Creado Por</th>
                                <th>Fecha de Creación</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                            <tbody>
                                <?php foreach($pedido as $pedidos) : ?>
                                <tr>
                                <td data-titulo="Id"><?php echo $pedidos->id; ?></td>
                                <td data-titulo="Referencia"><?php echo $pedidos->referencia; ?></td>
                                <td data-titulo="Nombre"><?php echo $pedidos->categoria->nombre; ?></td>
                                <td data-titulo="Producto"><?php echo $pedidos->producto->nombre; ?></td>
                                <td data-titulo="Cantidad"><?php echo $pedidos->cantidad; ?></td>
                                <td data-titulo="Detalle" data-detalle="Detalle"><?php echo $pedidos->observacion; ?></td>
                                <td data-titulo="Estado">
                                    <?php if($pedidos->estado === 'Aceptado') : ?>
                                        <a class="estado aceptado"> Aceptado </a>
                                    <?php elseif($pedidos->estado === 'Rechazado'): ?>
                                        <a class="estado rechazado"> Rechazado </a>
                                    <?php else: ?>
                                        <a class="estado pendiente"> Pendiente </a>
                                    <?php endif ?>              
                                </td>
                                <td data-titulo="Creador"><?php echo $pedidos->usuario->nombre . " " . $pedidos->usuario->apellido  ; ?></td>
                                <td data-titulo="Creado"><?php echo $pedidos->fechaCreacion; ?></td>
                                <td>
                                    <div class="acciones-tabla">
                                        <a class="boton-accion entrada" href="/pedido/actualizar?id=<?php echo $pedidos->id; ?>">
                                            <i class="fa-solid fa-eye"></i> Ver Pedido
                                        </a>                  
                                    </div>
                                </td>
                                <td>
                                    <div class="acciones-tabla">
                                        <a class="boton-accion salida" href="/pedido/gestionaReferencia?referencia=<?php echo $pedidos->referencia; ?>">
                                            <i class="fa-solid fa-eye"></i> Ver Referencia
                                        </a>                  
                                    </div>
                                </td>  
                                </tr>
                                <?php endforeach; ?>
                            <tbody>
                        </table>
                    </div>
                    <div class="form-botones final">
                        <a class="boton-exportar" href="pedido">Ver Pedidos</a>
                    </div>
                </div>
            </div>

    </form> 

<?php   
// Obtener los datos del reporte de ventas por día
$ventasPorDia = Venta::graficoVentasPorDia();

// Formatear los datos para Chart.js
$fechas = [];
$cantidadVentas = [];
$cantidadProductos = [];
$montoTotal = [];

foreach ($ventasPorDia as $venta) {
    $fechas[] = $venta->fecha;
    $cantidadVentas[] = $venta->cantidadVentas;
    $cantidadProductos[] = $venta->cantidadProductos;
    $montoTotal[] = $venta->montoTotal;
}

// Convertir datos a formato JSON
$fechasJson = json_encode($fechas);
$cantidadVentasJson = json_encode($cantidadVentas);
$cantidadProductosJson = json_encode($cantidadProductos);
$montoTotalJson = json_encode($montoTotal);
?>

<?php   
// Obtener los datos del reporte de ventas por producto
$ventasPorProducto = Venta::reporteVentasPorProducto();

// Formatear los datos para Chart.js
$productos = [];
$cantidadVentasProducto = [];
$montoTotalProducto = [];

foreach ($ventasPorProducto as $producto) {
    $productos[] = $producto->producto;
    $cantidadVentasProducto[] = $producto->cantidad_ventas;
    $montoTotalProducto[] = $producto->monto_total;
}

// Convertir datos a formato JSON
$productosJson = json_encode($productos);
$cantidadVentasProductoJson = json_encode($cantidadVentasProducto);
$montoTotalProductoJson = json_encode($montoTotalProducto);
?>

<?php   
// Obtener los datos del reporte de cobros por cliente
$cobrosPorCliente = Cobro::reporteCobrosPorCliente();

// Formatear los datos para Chart.js
$clientes = [];
$metodosPago = [];
$cantidadesPagadas = [];
$fechasRegistro = [];

foreach ($cobrosPorCliente as $cobro) {
    $clientes[] = $cobro->cliente;
    $metodosPago[] = $cobro->metodo_pago;
    $cantidadesPagadas[] = $cobro->cantidad_pagada;
    $fechasRegistro[] = $cobro->fecha_registro;
}

// Convertir datos a formato JSON
$clientesJson = json_encode($clientes);
$metodosPagoJson = json_encode($metodosPago);
$cantidadesPagadasJson = json_encode($cantidadesPagadas);
$fechasRegistroJson = json_encode($fechasRegistro);
?>

<?php   
// Obtener los datos del reporte de stock por producto y bodega
$stockPorProductoYBodega = Stock::reporteStockPorProductoYBodega();

// Formatear los datos para Chart.js
$productosStock = [];
$bodegasStock = [];
$cantidadesStock = [];
$movimientosStock = [];
$fechasCreacionStock = [];

foreach ($stockPorProductoYBodega as $stock) {
    $productosStock[] = $stock->producto;
    $bodegasStock[] = $stock->bodega;
    $cantidadesStock[] = $stock->cantidad;
    $movimientosStock[] = $stock->movimiento;
    $fechasCreacionStock[] = $stock->fechaCreacion;
}

// Convertir datos a formato JSON
$productosStockJson = json_encode($productosStock);
$bodegasStockJson = json_encode($bodegasStock);
$cantidadesStockJson = json_encode($cantidadesStock);
$movimientosStockJson = json_encode($movimientosStock);
$fechasCreacionStockJson = json_encode($fechasCreacionStock);
?>

<?php   
// Obtener los datos del reporte de pedidos por usuario
$pedidosPorUsuario = MaestroPedido::reportePedidosPorUsuario();

// Formatear los datos para Chart.js
$usuarios = [];
$referenciasPedidos = [];
$fechasCreacionPedidos = [];
$estadosPedidos = [];

foreach ($pedidosPorUsuario as $pedido) {
    $usuarios[] = $pedido->usuario;
    $referenciasPedidos[] = $pedido->referencia;
    $fechasCreacionPedidos[] = $pedido->fecha_creacion;
    $estadosPedidos[] = $pedido->estado;
}

// Convertir datos a formato JSON
$usuariosJson = json_encode($usuarios);
$referenciasPedidosJson = json_encode($referenciasPedidos);
$fechasCreacionPedidosJson = json_encode($fechasCreacionPedidos);
$estadosPedidosJson = json_encode($estadosPedidos);
?>

<?php   
// Obtener los datos del reporte de productos más vendidos
$productosMasVendidos = VentaProductos::reporteProductosMasVendidos();

// Formatear los datos para Chart.js
$productosVendidos = [];
$cantidadesVendidas = [];
$totalesIngresos = [];

foreach ($productosMasVendidos as $producto) {
    $productosVendidos[] = $producto->producto;
    $cantidadesVendidas[] = $producto->cantidad_vendida;
    $totalesIngresos[] = $producto->total_ingresos;
}

// Convertir datos a formato JSON
$productosVendidosJson = json_encode($productosVendidos);
$cantidadesVendidasJson = json_encode($cantidadesVendidas);
$totalesIngresosJson = json_encode($totalesIngresos);
?>

<?php   
// Obtener los datos del reporte de kardex por producto y bodega
$kardexPorProductoYBodega = Inventario::reporteKardexPorProductoYBodega();

// Formatear los datos para Chart.js
$productosKardex = [];
$bodegasKardex = [];
$entradas = [];
$salidas = [];
$totalesKardex = [];
$fechasKardex = [];

foreach ($kardexPorProductoYBodega as $kardex) {
    $productosKardex[] = $kardex->producto;
    $bodegasKardex[] = $kardex->bodega;
    $entradas[] = $kardex->entrada;
    $salidas[] = $kardex->salida;
    $totalesKardex[] = $kardex->total;
    $fechasKardex[] = $kardex->fecha;
}

// Convertir datos a formato JSON
$productosKardexJson = json_encode($productosKardex);
$bodegasKardexJson = json_encode($bodegasKardex);
$entradasJson = json_encode($entradas);
$salidasJson = json_encode($salidas);
$totalesKardexJson = json_encode($totalesKardex);
$fechasKardexJson = json_encode($fechasKardex);
?>

<?php   
// Obtener los datos del reporte de clientes con deuda
$clientesConDeuda = Cobro::reporteClientesConDeuda();

// Formatear los datos para Chart.js
$clientesDeuda = [];
$totalesDeuda = [];

foreach ($clientesConDeuda as $cliente) {
    $clientesDeuda[] = $cliente->cliente;
    $totalesDeuda[] = $cliente->total_deuda;
}

// Convertir datos a formato JSON
$clientesDeudaJson = json_encode($clientesDeuda);
$totalesDeudaJson = json_encode($totalesDeuda);
?>

<?php   
// Obtener los datos del reporte de defectos por producto y bodega
$defectosPorProductoYBodega = ReporteDefecto::reporteDefectosPorProductoYBodega();

// Formatear los datos para Chart.js
$productosDefectos = [];
$bodegasDefectos = [];
$cantidadesDefectos = [];
$observacionesDefectos = [];
$fechasDefectos = [];

foreach ($defectosPorProductoYBodega as $defecto) {
    $productosDefectos[] = $defecto->producto;
    $bodegasDefectos[] = $defecto->bodega;
    $cantidadesDefectos[] = $defecto->cantidad;
    $observacionesDefectos[] = $defecto->observacion;
    $fechasDefectos[] = $defecto->fecha;
}

// Convertir datos a formato JSON
$productosDefectosJson = json_encode($productosDefectos);
$bodegasDefectosJson = json_encode($bodegasDefectos);
$cantidadesDefectosJson = json_encode($cantidadesDefectos);
$observacionesDefectosJson = json_encode($observacionesDefectos);
$fechasDefectosJson = json_encode($fechasDefectos);
?>

<?php   
// Obtener los datos del reporte de regalías por producto y bodega
$regaliasPorProductoYBodega = Regalia::reporteRegaliasPorProductoYBodega();

// Formatear los datos para Chart.js
$productosRegalias = [];
$bodegasRegalias = [];
$cantidadesRegalias = [];
$observacionesRegalias = [];
$fechasRegalias = [];

foreach ($regaliasPorProductoYBodega as $regalia) {
    $productosRegalias[] = $regalia->producto;
    $bodegasRegalias[] = $regalia->bodega;
    $cantidadesRegalias[] = $regalia->cantidad;
    $observacionesRegalias[] = $regalia->observacion;
    $fechasRegalias[] = $regalia->fecha;
}

// Convertir datos a formato JSON
$productosRegaliasJson = json_encode($productosRegalias);
$bodegasRegaliasJson = json_encode($bodegasRegalias);
$cantidadesRegaliasJson = json_encode($cantidadesRegalias);
$observacionesRegaliasJson = json_encode($observacionesRegalias);
$fechasRegaliasJson = json_encode($fechasRegalias);
?>

<!-- < ?php   
// Obtener los datos del reporte de ventas de última hora
$ventasUltimaHora = VentaUltimaHora::reporteVentasUltimaHora();

// Formatear los datos para Chart.js
$nombres = [];
$nacionalidades = [];
$cantidadesPersonas = [];
$totalesDolares = [];
$totalesColones = [];
$fechasUltimaHora = [];

foreach ($ventasUltimaHora as $venta) {
    $nombres[] = $venta->nombre;
    $nacionalidades[] = $venta->nacionalidad;
    $cantidadesPersonas[] = $venta->cantidad_personas;
    $totalesDolares[] = $venta->total_dolares;
    $totalesColones[] = $venta->total_colones;
    $fechasUltimaHora[] = $venta->fecha;
}

// Convertir datos a formato JSON
$nombresJson = json_encode($nombres);
$nacionalidadesJson = json_encode($nacionalidades);
$cantidadesPersonasJson = json_encode($cantidadesPersonas);
$totalesDolaresJson = json_encode($totalesDolares);
$totalesColonesJson = json_encode($totalesColones);
$fechasUltimaHoraJson = json_encode($fechasUltimaHora);
?> -->

<?php   
// Obtener los datos del reporte de pasajeros por guía
$pasajerosPorGuia = ReportePasajero::reportePasajerosPorGuia();

// Formatear los datos para Chart.js
$fechasPasajeros = [];
$guia1 = [];
$pasajerosGuia1 = [];
$guia2 = [];
$pasajerosGuia2 = [];
$guia3 = [];
$pasajerosGuia3 = [];
$guia4 = [];
$pasajerosGuia4 = [];
$guia5 = [];
$pasajerosGuia5 = [];

foreach ($pasajerosPorGuia as $reporte) {
    $fechasPasajeros[] = $reporte->fecha;
    $guia1[] = $reporte->guia1;
    $pasajerosGuia1[] = $reporte->guia1_pasajeros;
    $guia2[] = $reporte->guia2;
    $pasajerosGuia2[] = $reporte->guia2_pasajeros;
    $guia3[] = $reporte->guia3;
    $pasajerosGuia3[] = $reporte->guia3_pasajeros;
    $guia4[] = $reporte->guia4;
    $pasajerosGuia4[] = $reporte->guia4_pasajeros;
    $guia5[] = $reporte->guia5;
    $pasajerosGuia5[] = $reporte->guia5_pasajeros;
}

// Convertir datos a formato JSON
$fechasPasajerosJson = json_encode($fechasPasajeros);
$guia1Json = json_encode($guia1);
$pasajerosGuia1Json = json_encode($pasajerosGuia1);
$guia2Json = json_encode($guia2);
$pasajerosGuia2Json = json_encode($pasajerosGuia2);
$guia3Json = json_encode($guia3);
$pasajerosGuia3Json = json_encode($pasajerosGuia3);
$guia4Json = json_encode($guia4);
$pasajerosGuia4Json = json_encode($pasajerosGuia4);
$guia5Json = json_encode($guia5);
$pasajerosGuia5Json = json_encode($pasajerosGuia5);
?>

<?php   
// Obtener los datos del reporte de ventas por mes
$ventasPorMes = Venta::reporteVentasPorMes();

// Formatear los datos para Chart.js
$meses = [];
$cantidadVendidaMes = [];
$totalIngresosMes = [];

foreach ($ventasPorMes as $venta) {
    $meses[] = $venta->mes;
    $cantidadVendidaMes[] = $venta->cantidad_vendida;
    $totalIngresosMes[] = $venta->total_ingresos;
}

// Convertir datos a formato JSON
$mesesJson = json_encode($meses);
$cantidadVendidaMesJson = json_encode($cantidadVendidaMes);
$totalIngresosMesJson = json_encode($totalIngresosMes);
?>

<?php   
// Obtener los datos del reporte de clientes frecuentes
$clientesFrecuentes = Cliente::reporteClientesFrecuentes();

// Formatear los datos para Chart.js
$clientesFrecuentesNombres = [];
$totalCompras = [];
$totalProductos = [];
$totalGastado = [];

foreach ($clientesFrecuentes as $cliente) {
    $clientesFrecuentesNombres[] = $cliente->cliente;
    $totalCompras[] = $cliente->total_compras;
    $totalProductos[] = $cliente->total_productos;
    $totalGastado[] = $cliente->total_gastado;
}

// Convertir datos a formato JSON
$clientesFrecuentesNombresJson = json_encode($clientesFrecuentesNombres);
$totalComprasJson = json_encode($totalCompras);
$totalProductosJson = json_encode($totalProductos);
$totalGastadoJson = json_encode($totalGastado);
?>

<?php   
// Obtener los datos del reporte de productos con mayor stock
$productosConMayorStock = Producto::reporteProductosConMayorStock();

// Formatear los datos para Chart.js
$productosMayorStock = [];
$totalStock = [];

foreach ($productosConMayorStock as $producto) {
    $productosMayorStock[] = $producto->producto;
    $totalStock[] = $producto->total_stock;
}

// Convertir datos a formato JSON
$productosMayorStockJson = json_encode($productosMayorStock);
$totalStockJson = json_encode($totalStock);
?>

<?php   
// Obtener los datos del reporte de productos sin movimiento
$productosSinMovimiento = Producto::reporteProductosSinMovimiento();

// Formatear los datos para Chart.js
$productosSinMovimientoNombres = [];
$bodegasSinMovimiento = [];
$ultimaFechaMovimiento = [];

foreach ($productosSinMovimiento as $producto) {
    $productosSinMovimientoNombres[] = $producto->producto;
    $bodegasSinMovimiento[] = $producto->bodega;
    $ultimaFechaMovimiento[] = $producto->ultima_fecha_movimiento;
}

// Convertir datos a formato JSON
$productosSinMovimientoNombresJson = json_encode($productosSinMovimientoNombres);
$bodegasSinMovimientoJson = json_encode($bodegasSinMovimiento);
$ultimaFechaMovimientoJson = json_encode($ultimaFechaMovimiento);
?> 


<?php   
// Obtener los datos del reporte de ventas por categoría de producto
$ventasPorCategoria = Producto::reporteVentasPorCategoriaDeProducto();

// Formatear los datos para Chart.js
$categorias = [];
$cantidadVendidaCategoria = [];
$totalIngresosCategoria = [];

foreach ($ventasPorCategoria as $venta) {
    $categorias[] = $venta->categoria;
    $cantidadVendidaCategoria[] = $venta->cantidad_vendida;
    $totalIngresosCategoria[] = $venta->total_ingresos;
}

// Convertir datos a formato JSON
$categoriasJson = json_encode($categorias);
$cantidadVendidaCategoriaJson = json_encode($cantidadVendidaCategoria);
$totalIngresosCategoriaJson = json_encode($totalIngresosCategoria);
?>

<!-- < ?php   
// Obtener los datos del reporte de productos devueltos por cliente
$productosDevueltosPorCliente = Reporte::reporteProductosDevueltosPorCliente();

// Formatear los datos para Chart.js
$clientesDevueltos = [];
$productosDevueltos = [];
$cantidadesDevueltas = [];
$fechasDevueltas = [];

foreach ($productosDevueltosPorCliente as $devolucion) {
    $clientesDevueltos[] = $devolucion->cliente;
    $productosDevueltos[] = $devolucion->producto;
    $cantidadesDevueltas[] = $devolucion->cantidad_devuelta;
    $fechasDevueltas[] = $devolucion->fecha;
}

// Convertir datos a formato JSON
$clientesDevueltosJson = json_encode($clientesDevueltos);
$productosDevueltosJson = json_encode($productosDevueltos);
$cantidadesDevueltasJson = json_encode($cantidadesDevueltas);
$fechasDevueltasJson = json_encode($fechasDevueltas);
?> -->

<?php   
// Obtener los datos del reporte de ingresos y egresos por bodega
$ingresosYEgresosPorBodega = Stock::reporteIngresosYEgresosPorBodega();

// Formatear los datos para Chart.js
$bodegasIngresosEgresos = [];
$totalIngresosBodega = [];
$totalEgresosBodega = [];

foreach ($ingresosYEgresosPorBodega as $bodega) {
    $bodegasIngresosEgresos[] = $bodega->bodega;
    $totalIngresosBodega[] = $bodega->total_ingresos;
    $totalEgresosBodega[] = $bodega->total_egresos;
}

// Convertir datos a formato JSON
$bodegasIngresosEgresosJson = json_encode($bodegasIngresosEgresos);
$totalIngresosBodegaJson = json_encode($totalIngresosBodega);
$totalEgresosBodegaJson = json_encode($totalEgresosBodega);
?>


<script>
    // Datos de los reportes
    var fechas = <?php echo $fechasJson; ?>;
    var cantidadVentas = <?php echo $cantidadVentasJson; ?>;
    var cantidadProductos = <?php echo $cantidadProductosJson; ?>;
    var montoTotal = <?php echo $montoTotalJson; ?>;

    var productos = <?php echo $productosJson; ?>;
    var cantidadVentasProducto = <?php echo $cantidadVentasProductoJson; ?>;
    var montoTotalProducto = <?php echo $montoTotalProductoJson; ?>;

    var clientes = <?php echo $clientesJson; ?>;
    var metodosPago = <?php echo $metodosPagoJson; ?>;
    var cantidadesPagadas = <?php echo $cantidadesPagadasJson; ?>;
    var fechasRegistro = <?php echo $fechasRegistroJson; ?>;

    var productosStock = <?php echo $productosStockJson; ?>;
    var bodegasStock = <?php echo $bodegasStockJson; ?>;
    var cantidadesStock = <?php echo $cantidadesStockJson; ?>;
    var movimientosStock = <?php echo $movimientosStockJson; ?>;
    var fechasCreacionStock = <?php echo $fechasCreacionStockJson; ?>;

    var usuarios = <?php echo $usuariosJson; ?>;
    var referenciasPedidos = <?php echo $referenciasPedidosJson; ?>;
    var fechasCreacionPedidos = <?php echo $fechasCreacionPedidosJson; ?>;
    var estadosPedidos = <?php echo $estadosPedidosJson; ?>;

    var productosVendidos = <?php echo $productosVendidosJson; ?>;
    var cantidadesVendidas = <?php echo $cantidadesVendidasJson; ?>;
    var totalesIngresos = <?php echo $totalesIngresosJson; ?>;

    var productosKardex = <?php echo $productosKardexJson; ?>;
    var bodegasKardex = <?php echo $bodegasKardexJson; ?>;
    var entradas = <?php echo $entradasJson; ?>;
    var salidas = <?php echo $salidasJson; ?>;
    var totalesKardex = <?php echo $totalesKardexJson; ?>;
    var fechasKardex = <?php echo $fechasKardexJson; ?>;

    var clientesDeuda = <?php echo $clientesDeudaJson; ?>;
    var totalesDeuda = <?php echo $totalesDeudaJson; ?>;

    var productosDefectos = <?php echo $productosDefectosJson; ?>;
    var bodegasDefectos = <?php echo $bodegasDefectosJson; ?>;
    var cantidadesDefectos = <?php echo $cantidadesDefectosJson; ?>;
    var observacionesDefectos = <?php echo $observacionesDefectosJson; ?>;
    var fechasDefectos = <?php echo $fechasDefectosJson; ?>;

    var productosRegalias = <?php echo $productosRegaliasJson; ?>;
    var bodegasRegalias = <?php echo $bodegasRegaliasJson; ?>;
    var cantidadesRegalias = <?php echo $cantidadesRegaliasJson; ?>;
    var observacionesRegalias = <?php echo $observacionesRegaliasJson; ?>;
    var fechasRegalias = <?php echo $fechasRegaliasJson; ?>;

    var fechasPasajeros = <?php echo $fechasPasajerosJson; ?>;
    var guia1 = <?php echo $guia1Json; ?>;
    var pasajerosGuia1 = <?php echo $pasajerosGuia1Json; ?>;
    var guia2 = <?php echo $guia2Json; ?>;
    var pasajerosGuia2 = <?php echo $pasajerosGuia2Json; ?>;
    var guia3 = <?php echo $guia3Json; ?>;
    var pasajerosGuia3 = <?php echo $pasajerosGuia3Json; ?>;
    var guia4 = <?php echo $guia4Json; ?>;
    var pasajerosGuia4 = <?php echo $pasajerosGuia4Json; ?>;
    var guia5 = <?php echo $guia5Json; ?>;
    var pasajerosGuia5 = <?php echo $pasajerosGuia5Json; ?>;

    var meses = <?php echo $mesesJson; ?>;
    var cantidadVendidaMes = <?php echo $cantidadVendidaMesJson; ?>;
    var totalIngresosMes = <?php echo $totalIngresosMesJson; ?>;

    var clientesFrecuentesNombres = <?php echo $clientesFrecuentesNombresJson; ?>;
    var totalCompras = <?php echo $totalComprasJson; ?>;
    var totalProductos = <?php echo $totalProductosJson; ?>;
    var totalGastado = <?php echo $totalGastadoJson; ?>;

    var productosMayorStock = <?php echo $productosMayorStockJson; ?>;
    var totalStock = <?php echo $totalStockJson; ?>;

    var productosSinMovimientoNombres = <?php echo $productosSinMovimientoNombresJson; ?>;
    var ultimaFechaMovimiento = <?php echo $ultimaFechaMovimientoJson; ?>;

    var categorias = <?php echo $categoriasJson; ?>;
    var cantidadVendidaCategoria = <?php echo $cantidadVendidaCategoriaJson; ?>;
    var totalIngresosCategoria = <?php echo $totalIngresosCategoriaJson; ?>;

    // Configuración de los gráficos
    function crearGrafico(ctx, tipo, labels, datasets) {
        return new Chart(ctx, {
            type: tipo,
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Reporte 1: Ventas por Día
    var ctxVentasPorDia = document.getElementById('ventasPorDiaChart').getContext('2d');
    var ventasPorDiaChart = crearGrafico(ctxVentasPorDia, 'bar', fechas, [
        {
            label: 'Cantidad de Ventas',
            data: cantidadVentas,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        },
        {
            label: 'Cantidad de Productos Vendidos',
            data: cantidadProductos,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        },
        {
            label: 'Monto Total de Ventas',
            data: montoTotal,
            backgroundColor: 'rgba(255, 206, 86, 0.2)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1
        }
    ]);

    // Reporte 2: Ventas por Producto
    var ctxVentasPorProducto = document.getElementById('ventasPorProductoChart').getContext('2d');
    var ventasPorProductoChart = crearGrafico(ctxVentasPorProducto, 'bar', productos, [
        {
            label: 'Cantidad de Ventas por Producto',
            data: cantidadVentasProducto,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        },
        {
            label: 'Monto Total por Producto',
            data: montoTotalProducto,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }
    ]);

    // Reporte 3: Cobros por Cliente
    var ctxCobrosPorCliente = document.getElementById('cobrosPorClienteChart').getContext('2d');
    var cobrosPorClienteChart = crearGrafico(ctxCobrosPorCliente, 'bar', clientes, [
        {
            label: 'Cantidad Pagada',
            data: cantidadesPagadas,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }
    ]);

    // Reporte 4: Stock por Producto y Bodega
    var ctxStockPorProductoYBodega = document.getElementById('stockPorProductoYBodegaChart').getContext('2d');
    var stockPorProductoYBodegaChart = crearGrafico(ctxStockPorProductoYBodega, 'bar', productosStock, [
        {
            label: 'Cantidad en Stock',
            data: cantidadesStock,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }
    ]);

    // Reporte 5: Pedidos por Usuario
    var ctxPedidosPorUsuario = document.getElementById('pedidosPorUsuarioChart').getContext('2d');
    var pedidosPorUsuarioChart = crearGrafico(ctxPedidosPorUsuario, 'bar', usuarios, [
        {
            label: 'Cantidad de Pedidos',
            data: referenciasPedidos,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }
    ]);

    // Reporte 6: Productos Vendidos
    var ctxProductosVendidos = document.getElementById('productosVendidosChart').getContext('2d');
    var productosVendidosChart = crearGrafico(ctxProductosVendidos, 'bar', productosVendidos, [
        {
            label: 'Cantidad Vendida',
            data: cantidadesVendidas,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        },
        {
            label: 'Total Ingresos',
            data: totalesIngresos,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }
    ]);

    // Reporte 7: Kardex de Productos
    var ctxKardexProductos = document.getElementById('kardexProductosChart').getContext('2d');
    var kardexProductosChart = crearGrafico(ctxKardexProductos, 'bar', productosKardex, [
        {
            label: 'Entradas',
            data: entradas,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        },
        {
            label: 'Salidas',
            data: salidas,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        },
        {
            label: 'Total',
            data: totalesKardex,
            backgroundColor: 'rgba(255, 206, 86, 0.2)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1
        }
    ]);

    // Reporte 8: Deudas por Cliente
    var ctxDeudasPorCliente = document.getElementById('deudasPorClienteChart').getContext('2d');
    var deudasPorClienteChart = crearGrafico(ctxDeudasPorCliente, 'bar', clientesDeuda, [
        {
            label: 'Total Deuda',
            data: totalesDeuda,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }
    ]);

    // Reporte 9: Productos con Defectos
    var ctxProductosDefectos = document.getElementById('productosDefectosChart').getContext('2d');
    var productosDefectosChart = crearGrafico(ctxProductosDefectos, 'bar', productosDefectos, [
        {
            label: 'Cantidad Defectuosa',
            data: cantidadesDefectos,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }
    ]);

    // Reporte 10: Productos con Regalías
    var ctxProductosRegalias = document.getElementById('productosRegaliasChart').getContext('2d');
    var productosRegaliasChart = crearGrafico(ctxProductosRegalias, 'bar', productosRegalias, [
        {
            label: 'Cantidad Regalías',
            data: cantidadesRegalias,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }
    ]);

    // Reporte 11: Pasajeros por Guía
    var ctxPasajerosPorGuia = document.getElementById('pasajerosPorGuiaChart').getContext('2d');
    var pasajerosPorGuiaChart = crearGrafico(ctxPasajerosPorGuia, 'bar', guia1, [
        {
            label: 'Pasajeros',
            data: pasajerosGuia1,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }
    ]);

    // Reporte 12: Ventas por Mes
    var ctxVentasPorMes = document.getElementById('ventasPorMesChart').getContext('2d');
    var ventasPorMesChart = crearGrafico(ctxVentasPorMes, 'bar', meses, [
        {
            label: 'Cantidad Vendida por Mes',
            data: cantidadVendidaMes,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        },
        {
            label: 'Total Ingresos por Mes',
            data: totalIngresosMes,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }
    ]);

    // Reporte 13: Clientes Frecuentes
    var ctxClientesFrecuentes = document.getElementById('clientesFrecuentesChart').getContext('2d');
    var clientesFrecuentesChart = crearGrafico(ctxClientesFrecuentes, 'bar', clientesFrecuentesNombres, [
        {
            label: 'Total Compras',
            data: totalCompras,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        },
        {
            label: 'Total Productos',
            data: totalProductos,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        },
        {
            label: 'Total Gastado',
            data: totalGastado,
            backgroundColor: 'rgba(255, 206, 86, 0.2)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1
        }
    ]);

    // Reporte 14: Productos con Mayor Stock
    var ctxProductosMayorStock = document.getElementById('productosMayorStockChart').getContext('2d');
    var productosMayorStockChart = crearGrafico(ctxProductosMayorStock, 'bar', productosMayorStock, [
        {
            label: 'Total Stock',
            data: totalStock,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }
    ]);

    // Reporte 15: Productos sin Movimiento
    var ctxProductosSinMovimiento = document.getElementById('productosSinMovimientoChart').getContext('2d');
    var productosSinMovimientoChart = crearGrafico(ctxProductosSinMovimiento, 'line', productosSinMovimientoNombres, [
        {
            label: 'Última Fecha de Movimiento',
            data: ultimaFechaMovimiento,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }
    ]);

    // Reporte 16: Ventas por Categoría
    var ctxVentasPorCategoria = document.getElementById('ventasPorCategoriaChart').getContext('2d');
    var ventasPorCategoriaChart = crearGrafico(ctxVentasPorCategoria, 'bar', categorias, [
        {
            label: 'Cantidad Vendida por Categoría',
            data: cantidadVendidaCategoria,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        },
        {
            label: 'Total Ingresos por Categoría',
            data: totalIngresosCategoria,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }
    ]);
    
</script>



</section>   
