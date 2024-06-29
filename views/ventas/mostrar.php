<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
        <span class="text">Control de Ventas</span>
    </div>
        
    <form class="form form-contenido form-botones">
        <a class="boton-exportar" href="/ventas/carrito"> <i class="fa-regular fa-square-plus"></i> Crear Venta </a>
        <a class="boton-exportar" href="/cobros/seleccionarCliente"> <i class="fa-regular fa-square-plus"></i> Cobrar a Cliente </a>
        <a class="boton-exportar pdf" href="/fpdf/pdfVentas" target="_blank"> <i class="fa-solid fa-file-pdf"></i> PDF </a>  
        <button id="btnExportar" class="boton-exportar"> <i class="fa-solid fa-file-excel"></i> EXCEL </button> 
    </form>

    <form class="form form-contenido form-botones">
        <div class="campo campo-unido">
            <label for="filtroCliente">Buscar Cliente:</label>
            <input type="text" id="filtroCliente" placeholder="Filtrar por Cliente">
        </div>
        <div class="campo campo-unido">
            <label for="filtroFechaInicio">Fecha Inicio:</label>
            <input type="date" id="filtroFechaInicio" placeholder="Fecha Inicio">
        </div>
        <div class="campo campo-unido">
            <label for="filtroFechaFin">Fecha Fin:</label>
            <input type="date" id="filtroFechaFin" placeholder="Fecha Fin">
        </div>
        <div class="campo campo-unido">
            <label for="filtroEstado">Filtrar Estado:</label>
            <select id="filtroEstado" style="width: 100%;">
                <option disabled selected value>-- Filtrar Estado --</option>
                <option value="">Mostrar Todos</option>
                <option value="Cancelado">Cancelado</option>
                <option value="Pendiente">Pendiente</option>               
            </select>
        </div>
    </form>

    <form action="" class="form form-contenido form-tabla" method="POST" enctype="multipart/form-data"> 
        <table class="tabla" id="">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Código Brazalete</th>
                    <th>Fecha Venta</th>
                    <th>Cantidad por Pagar</th>
                    <th>Cantidad Pagada</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($venta)) { ?>
                    <?php foreach($venta as $ventas) : ?> 
                        <?php     
                            $isVerMas = isset($_GET['id']) && $_GET['id'] == $ventas->id && isset($_GET['action']) && $_GET['action'] == 'ver_mas'; 
                            
                            // Convertir la fecha de creación al formato dd-mm-yyyy
                            $fechaCreacion = new DateTime($ventas->fecha);
                            $fechaCreacionFormateada = $fechaCreacion->format('d-m-Y H:i:s');
                        ?>
                        <tr>
                            <td>
                                <div class="acciones-tabla">
                                    <?php if(!$isVerMas) : ?> <!-- Mostrar el botón "Ver Más" solo si no se está mostrando la tabla -->
                                        <a class="boton-accion entrada" href="?id=<?php echo $ventas->id; ?>&action=<?php echo $isVerMas ? 'ocultar' : 'ver_mas'; ?>">
                                            <i class="fa-regular fa-eye accion toggle-on"></i>
                                        </a>
                                    <?php else: ?> <!-- Si se está mostrando la tabla, mostrar el botón "Ocultar" -->
                                        <a class="boton-accion entrada" href="?id=<?php echo $ventas->id; ?>&action=<?php echo $isVerMas ? 'ocultar' : 'ver_mas'; ?>">
                                            <i class="fa-regular fa-eye-slash accion toggle-off"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td data-titulo="Id"><?php echo $ventas->id; ?></td>
                            <td data-titulo="Nombre"><?php echo $ventas->cliente->nombre;?></td>
                            <td data-titulo="Brazalete"><?php echo $ventas->cliente->codigo_brazalete;?></td>
                            <td data-titulo="Fecha"><?php echo $fechaCreacionFormateada; ?></td>
                            <!-- Nuevas columnas para detalles del cobro -->
                            <?php
                            
                            // Calcular la cantidad por pagar
                            $cantidadPorPagar = 0;
                            foreach ($ventaProducto as $vp) {
                                if ($vp->venta_id == $ventas->id) {
                                    $cantidadPorPagar += $vp->precio * 1;
                                }
                            }

                                $cobro = null; 
                                foreach ($cobros as $c) { 
                                    if ($c->venta_id == $ventas->id) { 
                                        $cobro = $c; 
                                        break; 
                                    } 
                                } 
                            ?>
                            <td data-titulo="Cantidad por Pagar">
                                <?php
                                // Obtener el símbolo de moneda según el método de pago
                                $simboloMoneda = '';
                                
                                // Iterar sobre los productos de venta para obtener el método de pago
                                foreach($ventaProducto as $vp) {
                                    if ($vp->venta_id == $ventas->id) {
                                        if (strpos($vp->metodoPago, 'tarjeta-colones') !== false || strpos($vp->metodoPago, 'sinpe') !== false || strpos($vp->metodoPago, 'efectivo-colones') !== false) {
                                            $simboloMoneda = '₡';
                                        } elseif (strpos($vp->metodoPago, 'tarjeta-dolares') !== false || strpos($vp->metodoPago, 'efectivo-colones') !== false) {
                                            $simboloMoneda = '$';
                                        }
                                        break; // Romper el bucle una vez que se haya encontrado el método de pago
                                    }
                                }
                                
                                echo $simboloMoneda . ' ' . $cantidadPorPagar;
                                ?>
                            </td>
                            <td data-titulo="Cantidad Pagada"><?php echo isset($cobro) ? $simboloMoneda . ' ' . $cobro->cantidad_pagada : $simboloMoneda . ' ' .  0; ?></td>
                            <td data-titulo="Estado">
                                <?php if(isset($cobro) && isset($cobro->estado)) : ?>
                                    <a class="estado cancelado"> <?php echo $cobro->estado?></a>
                                <?php else: ?>
                                    <a class="estado pendientes"> Pendiente </a>
                                <?php endif ?>               
                            </td>
                        </tr>
                        <?php if($isVerMas) : ?>
                            <tr>
                                <td colspan="9">
                                    <table class="tabla" id="tabla2">
                                        <thead>
                                            <tr>  
                                                <th>ID
                                                <th>Venta</th>
                                                <th>Producto</th>
                                                <!-- <th>Receta</th> -->
                                                <th>Cantidad</th>
                                                <th>Precio</th>
                                                <th>Método Pago</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $ventaProductoEncontrado = false;
                                            foreach($ventaProducto as $ventaProductos) : 
                                                if($ventaProductos->venta_id == $ventas->id) {
                                                    $ventaProductoEncontrado = true;
                                            ?>
                                            <tr>
                                                <td data-titulo="Id"><?php echo $ventaProductos->id; ?></td>
                                                <td data-titulo="Venta"><?php echo $ventaProductos->venta_id; ?></td>
                                                <td data-titulo="Producto o Receta">
                                                    <?php if ($ventaProductos->producto_id !== 0 && $ventaProductos->producto) {
                                                        echo $ventaProductos->producto->nombre;
                                                    } elseif ($ventaProductos->receta_id !== 0 && $ventaProductos->receta) {
                                                        echo $ventaProductos->receta->nombre;
                                                    } else {
                                                        echo 'Nada';
                                                    } ?>
                                                </td>
                                                <td data-titulo="Cantidad"><?php echo $ventaProductos->cantidad; ?></td>
                                                <td data-titulo="Precio">
                                                    <?php
                                                    // Obtener el símbolo de moneda según el método de pago
                                                    $simboloMoneda = '';
                                                    
                                                    if (isset($ventaProductos)) {
                                                        if (strpos($ventaProductos->metodoPago, 'tarjeta-colones') !== false || strpos($ventaProductos->metodoPago, 'sinpe') !== false || strpos($ventaProductos->metodoPago, 'efectivo-colones') !== false) {
                                                            $simboloMoneda = '₡';
                                                        } elseif (strpos($ventaProductos->metodoPago, 'tarjeta-dolares') !== false || strpos($ventaProductos->metodoPago, 'efectivo-dolares') !== false) {
                                                            $simboloMoneda = '$';
                                                        }
                                                    }
                                                    echo $simboloMoneda . ' ' . $ventaProductos->precio;
                                                    ?>
                                                </td>
                                                <td data-titulo="Método Pago"><?php echo $ventaProductos->metodoPago; ?></td>
                                            </tr>
                                            <?php 
                                                }
                                            endforeach; 
                                            if (!$ventaProductoEncontrado) {
                                            ?>
                                            <tr>
                                                <td colspan="8" class="sin-registro">
                                                    <a class="sin-registro">Esta venta no posee productos</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        <?php } ?> 
            </tbody>
        </table>
    </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filtroCliente = document.getElementById('filtroCliente');
    const filtroFechaInicio = document.getElementById('filtroFechaInicio');
    const filtroFechaFin = document.getElementById('filtroFechaFin');
    const filtroEstado = document.getElementById('filtroEstado');
    const tabla = document.querySelector('.form-tabla tbody');

    function parseFecha(fechaStr) {
        const [dia, mes, añoHora] = fechaStr.split('-');
        const [año, hora] = añoHora.split(' ');
        return new Date(`${año}-${mes}-${dia}T${hora}`);
    }

    function filtrarTabla() {
        const cliente = filtroCliente.value.toLowerCase();
        const fechaInicio = filtroFechaInicio.value ? new Date(filtroFechaInicio.value) : null;
        const fechaFin = filtroFechaFin.value ? new Date(filtroFechaFin.value) : null;
        const estado = filtroEstado.value;
        
        Array.from(tabla.rows).forEach(row => {
            const clienteNombre = row.querySelector('td[data-titulo="Nombre"]').textContent.toLowerCase();
            const fechaVentaStr = row.querySelector('td[data-titulo="Fecha"]').textContent;
            const fechaVenta = parseFecha(fechaVentaStr);
            const estadoVenta = row.querySelector('td[data-titulo="Estado"] a').textContent;

            let mostrar = true;

            if (cliente && !clienteNombre.includes(cliente)) {
                mostrar = false;
            }

            if (fechaInicio && fechaVenta < fechaInicio) {
                mostrar = false;
            }

            if (fechaFin && fechaVenta > fechaFin) {
                mostrar = false;
            }

            if (estado && estado !== estadoVenta) {
                mostrar = false;
            }

            row.style.display = mostrar ? '' : 'none';
        });
    }

    filtroCliente.addEventListener('input', filtrarTabla);
    filtroFechaInicio.addEventListener('input', filtrarTabla);
    filtroFechaFin.addEventListener('input', filtrarTabla);
    filtroEstado.addEventListener('change', filtrarTabla);
});
</script>
