    <?php
        use Model\Cobro;
use Model\Venta;

    ?>

    <form action="/cobros/seleccionarCliente" method="POST">
        <div class="div-flex">
            <div class="campo campo-separado w-50">
                <label for="cliente">Selecciona un cliente:</label>
                <select class="buscar" id="cliente" name="cliente_id" required>
                    <option value="">--Seleccione un cliente--</option>
                    <?php foreach ($clientes as $cliente) : ?>
                        <option value="<?php echo $cliente->id; ?>"><?php echo $cliente->nombre . " - " . $cliente->codigo_brazalete; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="campo campo-separado w-50">
                <label for="agregar">Cargar Datos:</label>
                <input type="submit" value="Seleccionar Usuario" class="boton-exportar formulario">
            </div>
        </div>
    </form>

    <form class="form form-contenido contenedor-flex" action="/cobros/guardarCobro" method="POST">
        <?php if (!empty($ventaCliente) && is_object($ventaCliente)) : ?>
            <div style="width: inherit;">
                <h2 style="color: black; margin-bottom: 2rem;">Datos del Cliente:</h2>
                <?php
                    date_default_timezone_set("America/Costa_Rica");
                    setlocale(LC_ALL,"es_ES");
                ?>
                <p style="color: black;"><strong>Venta:</strong> Nº <?php echo $ventaCliente->id; ?></p>
                <p style="color: black;"><strong>Fecha: </strong><?php echo date("F, j, Y, g:i a"); ?></p>
                <p style="color: black;"><strong>Cliente:</strong> <?php echo $clienteSeleccionado->nombre . " - " . $clienteSeleccionado->codigo_brazalete; ?></p>
                <!-- <?php if (!empty($productosVenta)) : ?>
                    <?php foreach($productosVenta as $producto) : ?>
                        <?php $cobroVinculado = Cobro::findVenta($producto->venta_id); ?>
                        <?php if(!$cobroVinculado) : ?>
                            <?php $clienteProducto = Venta::find($producto->venta_id)->cliente; ?>
                            <?php if(intval($clienteProducto) == intval($clienteSeleccionado->id)) :?>
                                <p style="color: black;"><strong>Venta:</strong> <?php echo $producto->venta_id; ?></p>
                            <?php endif; ?>
                        <?php endif; ?>                   
                    <?php endforeach; ?> 
                <?php endif; ?> -->
            </div>
        <?php endif; ?>

        <?php if (!empty($productosVenta)) : ?>
            <form class="form form-contenido contenedor-flex" action="/cobros/guardarCobro" method="POST">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Método de Pago</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php 
                            $sumas = []; // Inicializamos un array para almacenar las sumas de precio por método de pago
                            $clienteTieneVentas = false; // Variable para verificar si el cliente tiene ventas
                            foreach ($productosVenta as $producto) : 
                                // Verificar si el producto tiene un cobro vinculado
                                $cobroVinculado = Cobro::findVenta($producto->venta_id);
                                if (!$cobroVinculado) :
                                    // Obtener el cliente asociado a la venta del producto
                                    $clienteProducto = Venta::find($producto->venta_id)->cliente;
                                    // Verificar si la venta pertenece al cliente seleccionado
                                    if (intval($clienteProducto) == intval($clienteSeleccionado->id)) : ?>
                                        <?php $clienteTieneVentas = true; // El cliente tiene ventas ?>       
                                    <tr>
                                        <td>
                                            <?php 
                                                if ($producto->receta_id == 0) {
                                                    echo $producto->producto->nombre;
                                                } elseif ($producto->producto_id == 0) {
                                                    echo $producto->receta->nombre;
                                                } 
                                            ?>
                                        </td>
                                        <td><?php echo $producto->cantidad; ?></td>
                                        <td><?php echo $producto->precio; ?></td>
                                        <td style="text-transform: capitalize;"><?php echo $producto->metodoPago; ?></td>
                                    </tr>
                                    <?php 
                                        // Agregar el precio del producto al array de sumas según el método de pago
                                        $sumas[$producto->metodoPago] = isset($sumas[$producto->metodoPago]) ? $sumas[$producto->metodoPago] + $producto->precio : $producto->precio;
                                    ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach;  ?>
                        <?php if (!$clienteTieneVentas) : ?>
                            <tr>
                                <td colspan="4" class="campo-vacio">
                                    <a class="sin-registro">Este cliente no posee ventas</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php if (!empty($sumas)) : ?>
                    <div>
                        <?php 
                            $sum_colones = 0;
                            $sum_dolares = 0;
                            foreach ($sumas as $metodoPago => $suma) : 
                                if ($metodoPago == 'tarjeta-colones' || $metodoPago == 'sinpe' || $metodoPago == 'efectivo-colones') {
                                    $sum_colones += $suma;
                                } elseif ($metodoPago == 'tarjeta-dolares' || $metodoPago == 'efectivo-dolares') {
                                    $sum_dolares += $suma;
                                }
                            endforeach;
                        ?>
                        <?php
                            $totalColones = ($sum_dolares * $_SESSION['tipo_cambio']) + $sum_colones ;
                            $totalDolares = ($sum_colones / $_SESSION['tipo_cambio']) + $sum_dolares;
                            ?>
                        <?php if ($sum_colones > 0 || $sum_dolares > 0) : ?>
                            <p style="color: black;"><strong>Monto Colones:</strong> ₡<?php echo number_format($totalColones, 0); ?></p>
                            <p style="color: black;"><strong>Monto Dólares:</strong> $<?php echo number_format($totalDolares, 2); ?></p>
                        <?php endif; ?>
                        <p style="color: black;"><strong style="text-transform: capitalize;"> Tipo cambio dolar: </strong><?php echo number_format($_SESSION['tipo_cambio'], 2) . " colones" ; ?></p>
                    </div>
                <?php endif; ?>

                <div class="div-flex">
                    <input type="hidden" name="cliente_id" value="<?php echo $clienteSeleccionado->id; ?>">
                    <input type="hidden" name="sumas" value='<?php echo json_encode($sumas); ?>'>

                    <div class="campo campo-separado w-50">
                        <label for="cantidad_pagada">Cantidad a Pagar:</label>
                        <input type="number" name="cantidad_pagada" min="0.01" step="0.01" value="<?php echo $totalDolares; ?>" required>
                    </div>

                    <div class="campo campo-separado w-50">
                        <label for="metodo_pago">Método de Pago:</label>
                        <select name="metodo_pago" required>
                            <option value="">--Seleccione el método de pago--</option>
                            <option value="tarjeta-dolares">Tarjeta (Dólares)</option>
                            <option value="tarjeta-colones">Tarjeta (Colones)</option>
                            <option value="sinpe">SINPE</option>
                            <option value="efectivo-dolares">Efectivo (Dólares)</option>
                            <option value="efectivo-colones">Efectivo (Colones)</option>
                            <!-- Agrega más métodos de pago si es necesario -->
                        </select>
                    </div>

                    <div class="campo campo-separado w-20">
                        <label for="agregar">Cobrar:</label>
                        <input type="submit" value="Cobrar" class="boton-exportar formulario">
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </form>






