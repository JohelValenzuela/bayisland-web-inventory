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
                <!-- Reporte XX: Pasajeros por Día -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Pasajeros por Día</h3>
                        <div class="contenedor-tabla">
                        <canvas id="pasajerosPorDiaChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte XX: Ventas por Usuario -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Ventas por Usuario</h3>
                        <div class="contenedor-tabla">
                        <canvas id="ventasPorUsuarioChart"></canvas>
                        </div>
                    </div>
                </div>
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
                <!-- Reporte 4: Stock por Producto y Bodega -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Stock por Producto y Bodega</h3>
                        <div class="contenedor-tabla">
                            <canvas id="stockPorProductoYBodegaChart"></canvas>
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
                <!-- Reporte 16: Ventas por Categoría -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Ventas por Categoría</h3>
                        <div class="contenedor-tabla">
                            <canvas id="ventasPorCategoriaChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 9: Productos con Defectos -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Productos con Defectos</h3>
                        <div class="contenedor-tabla">
                            <canvas id="defectosChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 10: Productos con Regalías -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Productos con Regalías</h3>
                        <div class="contenedor-tabla">
                            <canvas id="regaliasChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 3: Cobros por Cliente -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Ingresos y Egresos por Bodega</h3>
                        <div class="contenedor-tabla">
                            <canvas id="ingresosEgresosPorBodegaChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 3: Cobros por Cliente -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Cobros por Cliente</h3>
                        <div class="contenedor-tabla">
                            <canvas id="cobrosChart"></canvas>
                        </div>
                    </div>
                </div>
                <!-- Reporte 5: Pedidos por Usuario -->
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Pedidos por Usuario</h3>
                        <div class="contenedor-tabla">
                            <canvas id="pedidosChart"></canvas>
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


<?php //! Cobros por Cliente
// Obtener los datos del reporte de cobros por cliente
$cobrosPorCliente = Cobro::reporteCobrosPorCliente(); // Asegúrate de que esta función sea la que devuelve los datos ajustados

// Formatear los datos para Chart.js
$clientes = [];
$metodosPago = [];
$cantidadesPagadas = [];
$fechasRegistro = [];

foreach ($cobrosPorCliente as $cobro) {
    $clientes[] = $cobro->cliente;
    $metodosPago[] = $cobro->metodo_pago;
    $cantidadesPagadas[] = $cobro->cantidad_pagada;
    $fechasRegistro[] = $cobro->ultima_fecha;
}

// Convertir datos a formato JSON
$clientesJson = json_encode($clientes);
$metodosPagoJson = json_encode($metodosPago);
$cantidadesPagadasJson = json_encode($cantidadesPagadas);
$fechasRegistroJson = json_encode($fechasRegistro);
?>

<script>
        var ctx = document.getElementById('cobrosChart').getContext('2d');

        // Configurar el gráfico
        var cobrosChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico
            data: {
                labels: <?php echo $clientesJson; ?>, // Etiquetas de clientes
                datasets: [{
                    label: 'Cantidad Pagada',
                    data: <?php echo $cantidadesPagadasJson; ?>, // Datos de cantidades pagadas
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Clientes'
                        },
                        ticks: {
                            autoSkip: false,
                            maxRotation: 90,
                            minRotation: 90
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Cantidad Pagada'
                        },
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>



<?php   
// Obtener los datos del reporte de pedidos por usuario
$pedidosPorUsuario = MaestroPedido::reportePedidosPorUsuario();

// Formatear los datos para Chart.js
$usuarios = [];
$cantidadPedidos = [];

foreach ($pedidosPorUsuario as $pedido) {
    $usuarios[] = $pedido->usuario;
    $cantidadPedidos[] = $pedido->cantidad_pedidos;
}

// Convertir datos a formato JSON
$usuariosJson = json_encode($usuarios);
$cantidadPedidosJson = json_encode($cantidadPedidos);
?>


<script>
        var ctx = document.getElementById('pedidosChart').getContext('2d');

        // Configurar el gráfico
        var pedidosChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico
            data: {
                labels: <?php echo $usuariosJson; ?>, // Etiquetas de usuarios
                datasets: [{
                    label: 'Cantidad de Pedidos',
                    data: <?php echo $cantidadPedidosJson; ?>, // Datos de cantidad de pedidos
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Usuarios'
                        },
                        ticks: {
                            autoSkip: false,
                            maxRotation: 90,
                            minRotation: 90
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Cantidad de Pedidos'
                        },
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>

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

<script>
        var ctx = document.getElementById('productosMasVendidosChart').getContext('2d');
        
        // Configurar el gráfico
        var productosMasVendidosChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico
            data: {
                labels: <?php echo $productosVendidosJson; ?>, // Etiquetas de los productos
                datasets: [
                    {
                        label: 'Cantidad Vendida',
                        data: <?php echo $cantidadesVendidasJson; ?>, // Datos de cantidades vendidas
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total de Ingresos',
                        data: <?php echo $totalesIngresosJson; ?>, // Datos de totales de ingresos
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Cantidad / Ingreso'
                        }
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>

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

<script>
        var ctx = document.getElementById('kardexChart').getContext('2d');
        
        // Configurar el gráfico
        var kardexChart = new Chart(ctx, {
            type: 'line', // Tipo de gráfico
            data: {
                labels: <?php echo $fechasKardexJson; ?>, // Etiquetas de fechas
                datasets: [
                    {
                        label: 'Entradas',
                        data: <?php echo $entradasJson; ?>, // Datos de entradas
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: false
                    },
                    {
                        label: 'Salidas',
                        data: <?php echo $salidasJson; ?>, // Datos de salidas
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: false
                    },
                    {
                        label: 'Totales',
                        data: <?php echo $totalesKardexJson; ?>, // Datos de totales
                        borderColor: 'rgba(153, 102, 255, 1)',
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        fill: false
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Cantidad'
                        },
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>

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

 <script>
        var ctx = document.getElementById('deudaChart').getContext('2d');

        // Configurar el gráfico
        var deudaChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico
            data: {
                labels: <?php echo $clientesDeudaJson; ?>, // Etiquetas de clientes
                datasets: [{
                    label: 'Total Deuda',
                    data: <?php echo $totalesDeudaJson; ?>, // Datos de deuda
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Clientes'
                        },
                        ticks: {
                            autoSkip: false,
                            maxRotation: 90,
                            minRotation: 90
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Deuda'
                        },
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>





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

<script>
        var ctx = document.getElementById('pasajerosGuiaChart').getContext('2d');

        // Configurar el gráfico
        var pasajerosGuiaChart = new Chart(ctx, {
            type: 'line', // Tipo de gráfico
            data: {
                labels: <?php echo $fechasPasajerosJson; ?>, // Etiquetas de fechas
                datasets: [
                    {
                        label: 'Guía 1',
                        data: <?php echo $pasajerosGuia1Json; ?>, // Datos de pasajeros para Guía 1
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: false
                    },
                    {
                        label: 'Guía 2',
                        data: <?php echo $pasajerosGuia2Json; ?>, // Datos de pasajeros para Guía 2
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        fill: false
                    },
                    {
                        label: 'Guía 3',
                        data: <?php echo $pasajerosGuia3Json; ?>, // Datos de pasajeros para Guía 3
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: false
                    },
                    {
                        label: 'Guía 4',
                        data: <?php echo $pasajerosGuia4Json; ?>, // Datos de pasajeros para Guía 4
                        borderColor: 'rgba(153, 102, 255, 1)',
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        fill: false
                    },
                    {
                        label: 'Guía 5',
                        data: <?php echo $pasajerosGuia5Json; ?>, // Datos de pasajeros para Guía 5
                        borderColor: 'rgba(255, 159, 64, 1)',
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        fill: false
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Número de Pasajeros'
                        },
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>



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

<script>
        var ctx = document.getElementById('productosSinMovimientoChart').getContext('2d');

        // Configurar el gráfico
        var productosSinMovimientoChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico
            data: {
                labels: <?php echo $productosSinMovimientoNombresJson; ?>, // Nombres de productos sin movimiento
                datasets: [{
                    label: 'Última Fecha de Movimiento',
                    data: <?php echo $ultimaFechaMovimientoJson; ?>, // Fechas de última actividad
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Productos'
                        },
                        ticks: {
                            autoSkip: false, // Mostrar todas las etiquetas en el eje X
                            maxRotation: 90, // Rotar etiquetas si es necesario
                            minRotation: 30
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Fecha del Último Movimiento'
                        },
                        type: 'time',
                        time: {
                            unit: 'month',
                            displayFormats: {
                                month: 'MMM YYYY'
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                var date = new Date(value);
                                return date.toLocaleDateString('es-ES'); // Formatear fecha
                            }
                        }
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>



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
        var ctx = document.getElementById('ingresosEgresosPorBodegaChart').getContext('2d');

        // Configurar el gráfico
        var ingresosEgresosPorBodegaChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico
            data: {
                labels: <?php echo $bodegasIngresosEgresosJson; ?>, // Bodegas
                datasets: [{
                    label: 'Ingresos',
                    data: <?php echo $totalIngresosBodegaJson; ?>, // Total de ingresos por bodega
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Egresos',
                    data: <?php echo $totalEgresosBodegaJson; ?>, // Total de egresos por bodega
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Bodegas'
                        },
                        ticks: {
                            autoSkip: false, // Mostrar todas las etiquetas en el eje X
                            maxRotation: 90, // Rotar etiquetas si es necesario
                            minRotation: 30
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Monto'
                        },
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>


<?php //! Ventas por Usuario
// Obtener los datos del reporte de ventas por usuario
$ventasPorUsuario = Venta::reporteVentasPorUsuario();

// Formatear los datos para Chart.js
$usuarios = [];
$totalVentas = [];

foreach ($ventasPorUsuario as $venta) {
    $usuarios[] = $venta->usuario; // Usa el nombre del usuario
    $totalVentas[] = $venta->total_ventas; // Usa el total de ventas
}

// Convertir datos a formato JSON
$usuariosJson = json_encode($usuarios);
$totalVentasJson = json_encode($totalVentas);

?>

<script>
    // Reporte XX: Ventas por Usuario
    var ctx = document.getElementById('ventasPorUsuarioChart').getContext('2d');
        var usuarios = <?php echo $usuariosJson; ?>;
        var totalVentas = <?php echo $totalVentasJson; ?>;

        var ventasPorUsuarioChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: usuarios,
                datasets: [{
                    label: 'Total Ventas',
                    data: totalVentas,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
</script>




<?php //! Pasajeros por Día
// Obtener los datos del reporte de pasajeros por día
$pasajerosPorDia = ReportePasajero::obtenerPasajerosPorDia();

// Formatear los datos para Chart.js
$fechas = [];
$pasajerosTotales = [];

foreach ($pasajerosPorDia as $registro) {
    $fechas[] = $registro->fecha;
    $pasajerosTotales[] = $registro->total_pasajeros;
}

// Convertir datos a formato JSON
$fechasJson = json_encode($fechas);
$pasajerosTotalesJson = json_encode($pasajerosTotales);
?>

<script>
    // Reporte XX: Pasajeros por Día
    var fechas = <?php echo $fechasPasajerosJson; ?>;
    var totalPasajeros = <?php echo $pasajerosTotalesJson; ?>;

    var ctx = document.getElementById('pasajerosPorDiaChart').getContext('2d');
        
        // Datos de PHP en JavaScript
        var fechas = <?php echo $fechasJson; ?>;
        var totalPasajeros = <?php echo $pasajerosTotalesJson; ?>;
        
        // Crear gráfico
        var pasajerosPorDiaChart = new Chart(ctx, {
            type: 'bar', // Puedes cambiar el tipo a 'bar', 'line', etc.
            data: {
                labels: fechas, // Etiquetas del eje x
                datasets: [{
                    label: 'Total Pasajeros',
                    data: totalPasajeros, // Datos del gráfico
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
</script>


<?php //! Ventas por Día  
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

<script>
        var ctx = document.getElementById('ventasPorDiaChart').getContext('2d');
        var ventasPorDiaChart = new Chart(ctx, {
            type: 'line', // Puedes cambiar el tipo de gráfico según tu preferencia
            data: {
                labels: <?php echo $fechasJson; ?>,
                datasets: [
                    {
                        label: 'Cantidad de Ventas',
                        data: <?php echo $cantidadVentasJson; ?>,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1
                    },
                    {
                        label: 'Cantidad de Productos',
                        data: <?php echo $cantidadProductosJson; ?>,
                        borderColor: 'rgba(153, 102, 255, 1)',
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderWidth: 1
                    },
                    {
                        label: 'Monto Total',
                        data: <?php echo $montoTotalJson; ?>,
                        borderColor: 'rgba(255, 159, 64, 1)',
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>



<?php   //! Ventas por Producto 
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

<script>
        var ctx = document.getElementById('ventasPorProductoChart').getContext('2d');
        var ventasPorProductoChart = new Chart(ctx, {
            type: 'bar', // Cambia el tipo de gráfico según tu preferencia
            data: {
                labels: <?php echo $productosJson; ?>,
                datasets: [
                    {
                        label: 'Cantidad de Ventas por Producto',
                        data: <?php echo $cantidadVentasProductoJson; ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Monto Total por Producto',
                        data: <?php echo $montoTotalProductoJson; ?>,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

<?php //! Stock por producto y Bodega
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

<script>
        var ctx = document.getElementById('stockPorProductoYBodegaChart').getContext('2d');
        
        // Configurar el gráfico
        var stockPorProductoYBodegaChart = new Chart(ctx, {
            type: 'bar', // Cambia el tipo de gráfico según tu preferencia
            data: {
                labels: <?php echo $productosStockJson; ?>, // Etiquetas de los productos
                datasets: [
                    {
                        label: 'Cantidad de Stock',
                        data: <?php echo $cantidadesStockJson; ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Movimientos de Stock',
                        data: <?php echo $movimientosStockJson; ?>,
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>


<?php  //! Ventas por Mes  
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

<script>
        var ctx = document.getElementById('ventasPorMesChart').getContext('2d');

        // Configurar el gráfico
        var ventasPorMesChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico
            data: {
                labels: <?php echo $mesesJson; ?>, // Etiquetas de meses
                datasets: [
                    {
                        label: 'Cantidad Vendida',
                        data: <?php echo $cantidadVendidaMesJson; ?>, // Datos de cantidad vendida por mes
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Ingresos',
                        data: <?php echo $totalIngresosMesJson; ?>, // Datos de total de ingresos por mes
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Mes'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Cantidad / Ingresos'
                        },
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>

<?php  //! Clientes Frecuentes  
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

<script>
        var ctx = document.getElementById('clientesFrecuentesChart').getContext('2d');

        // Configurar el gráfico
        var clientesFrecuentesChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico
            data: {
                labels: <?php echo $clientesFrecuentesNombresJson; ?>, // Nombres de clientes frecuentes
                datasets: [
                    {
                        label: 'Total Compras',
                        data: <?php echo $totalComprasJson; ?>, // Datos de total de compras
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Productos',
                        data: <?php echo $totalProductosJson; ?>, // Datos de total de productos
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Gastado',
                        data: <?php echo $totalGastadoJson; ?>, // Datos de total gastado
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Clientes'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Cantidad'
                        },
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>

<?php //! Productos con mayor stock
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

<script>
        var ctx = document.getElementById('productosMayorStockChart').getContext('2d');

        // Configurar el gráfico
        var productosMayorStockChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico
            data: {
                labels: <?php echo $productosMayorStockJson; ?>, // Nombres de los productos con mayor stock
                datasets: [{
                    label: 'Total Stock',
                    data: <?php echo $totalStockJson; ?>, // Datos de total de stock
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Productos'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Cantidad de Stock'
                        },
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>


<?php //! Ventas por Categoría
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

<script>
        var ctx = document.getElementById('ventasPorCategoriaChart').getContext('2d');

        // Configurar el gráfico
        var ventasPorCategoriaChart = new Chart(ctx, {
            type: 'bar', // Tipo de gráfico
            data: {
                labels: <?php echo $categoriasJson; ?>, // Categorías de productos
                datasets: [{
                    label: 'Cantidad Vendida',
                    data: <?php echo $cantidadVendidaCategoriaJson; ?>, // Cantidades vendidas por categoría
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Total Ingresos',
                    data: <?php echo $totalIngresosCategoriaJson; ?>, // Total de ingresos por categoría
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Categorías de Producto'
                        },
                        ticks: {
                            autoSkip: false, // Mostrar todas las etiquetas en el eje X
                            maxRotation: 90, // Rotar etiquetas si es necesario
                            minRotation: 30
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Cantidad / Total Ingresos'
                        },
                        beginAtZero: true
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>

<?php    //! Defectos por Bodega
// Obtener los datos del reporte de defectos por bodega
$defectosPorBodega = ReporteDefecto::reporteDefectosPorBodega();

// Formatear los datos para Chart.js
$bodegasDefectos = [];
$cantidadesDefectos = [];

foreach ($defectosPorBodega as $defecto) {
    $bodegasDefectos[] = $defecto->bodega;
    $cantidadesDefectos[] = $defecto->cantidad_defectos; 
}

// Convertir datos a formato JSON
$bodegasDefectosJson = json_encode($bodegasDefectos);
$cantidadesDefectosJson = json_encode($cantidadesDefectos);
?>

<script>
    var ctx = document.getElementById('defectosChart').getContext('2d');

    // Configurar el gráfico
    var defectosChart = new Chart(ctx, {
        type: 'bar', // Tipo de gráfico
        data: {
            labels: <?php echo $bodegasDefectosJson; ?>, // Etiquetas de bodegas
            datasets: [{
                label: 'Cantidad de Defectos',
                data: <?php echo $cantidadesDefectosJson; ?>, // Datos de defectos
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Bodegas'
                    },
                    ticks: {
                        autoSkip: false,
                        maxRotation: 90,
                        minRotation: 90
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Cantidad de Defectos'
                    },
                    beginAtZero: true
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
</script>


<?php //! Regalias por Bodega
// Obtener los datos del reporte de regalías por bodega
$regaliasPorBodega = Regalia::reporteRegaliasPorBodega();

// Formatear los datos para Chart.js
$bodegasRegalias = [];
$cantidadesRegalias = [];

foreach ($regaliasPorBodega as $regalia) {
    $bodegasRegalias[] = $regalia->bodega;
    $cantidadesRegalias[] = $regalia->cantidad_regalias; // Aquí es donde debes usar la cantidad total de regalías
}

// Convertir datos a formato JSON
$bodegasRegaliasJson = json_encode($bodegasRegalias);
$cantidadesRegaliasJson = json_encode($cantidadesRegalias);
?>


<script>
    var ctx = document.getElementById('regaliasChart').getContext('2d');

    // Configurar el gráfico
    var regaliasChart = new Chart(ctx, {
        type: 'bar', // Tipo de gráfico
        data: {
            labels: <?php echo $bodegasRegaliasJson; ?>, // Etiquetas de bodegas
            datasets: [{
                label: 'Cantidad de Regalías',
                data: <?php echo $cantidadesRegaliasJson; ?>, // Datos de regalías
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Bodegas'
                    },
                    ticks: {
                        autoSkip: false,
                        maxRotation: 90,
                        minRotation: 90
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Cantidad de Regalías'
                    },
                    beginAtZero: true
                }
            },
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
</script>
    
</section>   
