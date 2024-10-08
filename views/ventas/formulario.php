<?php

use Model\Auth;
use Model\Producto;
use Model\Receta;
use Model\Cliente;

// Obtener todos los clientes
$clientes = Cliente::all();
$usuarios = Auth::all();
?>

<form action="/ventas/carrito" method="POST">
    <div class="div-flex">
        <div class="campo campo-separado w-40">
            <label for="cliente_switch">¿Cliente nuevo?</label>
            <div class="switch-container">
                <label class="switch">
                    <input type="checkbox" id="cliente_switch">
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
        <div class="campo campo-separado w-50" id="cliente_existente">
            <label for="cliente">Seleccionar Cliente:</label>
            <select class="buscar" name="cliente_id">
                <option value="">Seleccione un cliente</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo $cliente->id; ?>"><?php echo $cliente->nombre . " - " . $cliente->codigo_brazalete; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="campo campo-separado w-50" id="nuevo_cliente_div" style="display: none;">
            <label for="nuevo_cliente">Ingrese nuevo cliente:</label>
            <input type="text" id="nuevo_cliente" name="nuevo_cliente">
        </div>
        <div class="campo campo-separado w-50" id="codigo_brazalete_div" style="display: none;">
            <label for="codigo_brazalete">Código Brazalete:</label>
            <input type="text" id="codigo_brazalete" name="codigo_brazalete" maxlength="20">
        </div>
        <div class="campo campo-separado w-50">
            <label for="productoOrReceta">Seleccionar Producto o Receta:</label>
            <select class="buscar" name="productoOrReceta" required>
                <option value="">Seleccione un producto o receta</option>
                <?php foreach ($productos as $producto): ?>
                    <option value="<?php echo 'producto-' . $producto->id; ?>"><?php echo $producto->nombre . " " . $producto->presentacion; ?></option>
                <?php endforeach; ?>
                <?php foreach ($recetas as $receta): ?>
                    <option value="<?php echo 'receta-' . $receta->id; ?>"><?php echo $receta->nombre; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="div-flex">
        <div class="campo campo-separado w-30">
            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" min="1" value="1" required>
        </div>
        <div class="campo campo-separado w-30">
            <label for="precio">Precio:</label>
            <input type="number" name="precio" min="0.01" step="0.01" value="0.0" required>
        </div>
        <div class="campo campo-separado w-40">
            <label for="metodoPago">Método de Pago:</label>
            <select class="buscar" name="metodoPago">
                <option value="tarjeta-dolares">Tarjeta (Dólares)</option>
                <option value="tarjeta-colones">Tarjeta (Colones)</option>
                <option value="sinpe">SINPE</option>
                <option value="efectivo-dolares">Efectivo (Dólares)</option>
                <option value="efectivo-colones">Efectivo (Colones)</option>
            </select>
        </div>
        <?php if ($_SESSION['rol'] === 'Encargado'): ?>
            <div class="campo campo-separado w-50">
                <label for="vendedor_id">Seleccionar Vendedor:</label>
                <select class="buscar" name="vendedor_id">
                    <option value="">Seleccione un vendedor</option>
                    <?php foreach ($usuarios as $us): ?>
                        <option value="<?php echo $us->id; ?>"><?php echo $us->nombre . " " . $us->apellido; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php else: ?>
            <!-- Campo oculto con el ID del usuario si no se muestra el select -->
            <input type="hidden" name="vendedor_id" value="<?php echo htmlspecialchars($_SESSION['id']); ?>">
        <?php endif; ?>
        <div class="campo campo-separado w-30">
            <label for="agregar">Agregar</label>
            <input type="submit" value="Agregar al Carrito" class="boton-exportar formulario">
        </div>
    </div>
</form>

<section class="form form-contenido form-flex">
    <?php if (!empty($carrito)): ?>
        <div style="width: inherit;">
            <h2 style="color: black; margin-bottom: 5rem;">Lista de Productos en el Carrito</h2>
        </div>
        <table class="tabla table_id">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Código Brazalete</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Método de Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($carrito as $indice => $item): ?>
                <?php
                    // Obtener el nombre del producto o receta
                    $nombreProducto = $item['productoId'] ? Producto::find($item['productoId'])->nombre : '-';
                    $nombreReceta = $item['recetaId'] ? Receta::find($item['recetaId'])->nombre : '-';

                    // Obtener el nombre del cliente y su código de brazalete
                    $cliente = Cliente::find($item['cliente_id']);
                    $nombreCliente = $cliente->nombre;
                    $codigoBrazalete = $cliente->codigo_brazalete;
                ?>
                <tr>
                    <td><?php echo $nombreCliente; ?></td>
                    <td><?php echo $codigoBrazalete; ?></td>
                    <td>
                        <?php
                            if (isset($item['productoId'])) {
                                $producto = $nombreProducto;
                            } else if (isset($item['recetaId'])) {
                                $producto = $nombreReceta;
                            }
                            echo $producto;
                        ?>
                    </td>
                    <td><?php echo isset($item['precio']) ? '$' . $item['precio'] : '-'; ?></td>
                    <td><?php echo $item['cantidad']; ?></td>
                    <td><?php echo isset($item['metodoPago']) ? $item['metodoPago'] : '-'; ?></td>
                    <td>
                        <form action="/ventas/eliminarProductoCarrito" method="POST" style="display:inline;">
                            <input type="hidden" name="productoIndex" value="<?php echo $indice; ?>">
                            <input type="submit" value="Eliminar" class="boton-exportar cerrar">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <form action="/ventas/vaciarCarritoVentas" method="POST">
            <input type="submit" value="Vaciar Carrito" class="boton-exportar vaciar">
        </form>

        <form action="/ventas/realizarVenta" method="POST">
            <div class="campo campo-separado">
                <input type="submit" value="Realizar Venta" class="boton-exportar formulario">
            </div>
        </form>
    <?php endif; ?>
</section>
