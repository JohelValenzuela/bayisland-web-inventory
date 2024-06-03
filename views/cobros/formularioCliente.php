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
            <label for="agregar">Cargar Datos</label>
            <input type="submit" value="Seleccionar Usuario" class="boton-exportar formulario">
        </div>
    </div>

    <?php if (!empty($ventaCliente) && is_object($ventaCliente)) : ?>
        <div style="width: inherit; margin-top: 3rem;">
            <h2 style="color: black; margin-bottom: 3rem;">Datos del Cliente:</h2>
            <p style="color: black;"><strong>Nombre:</strong> <?php echo $clienteSeleccionado->nombre; ?></p>
            <p style="color: black;"><strong>Código de Brazalete:</strong> <?php echo $clienteSeleccionado->codigo_brazalete; ?></p>
            <?php foreach ($productosVenta as $producto) : ?>
                <?php if ($producto->venta_id == $ventaCliente->id) : ?>
                    <p style="color: black;"><strong>Venta:</strong> <?php echo $producto->venta_id; ?></p>
                    <?php break; endif;?> 
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($productosVenta)) : ?>
        <table class="tabla">
            <thead>
                <tr>
                    <!-- <th>Venta ID</th> -->
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Método de Pago</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $sumas = []; // Inicializamos un array para almacenar las sumas de precio por método de pago
                    foreach ($productosVenta as $producto) : ?>
                    <?php if (is_object($producto) && $producto->venta_id == $ventaCliente->id) : ?>
                        <tr>
                            <!-- <td><?php echo $producto->venta_id; ?></td> -->
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
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <?php if (!empty($sumas)) : ?>
        <div>
            <?php foreach ($sumas as $metodoPago => $suma) : ?>
                <p style="color: black;"><strong style="text-transform: capitalize;"><?php echo $metodoPago; ?>:</strong> <?php echo $suma; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="campo campo-separado w-20">
        <input type="submit" value="Cobrar" class="boton-exportar formulario">
    </div>

</form>
