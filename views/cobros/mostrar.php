<h1>Seleccionar Cliente</h1>
<form action="/cobros/mostrar" method="POST">
    <div>
        <label for="cliente">Selecciona un cliente:</label>
        <select id="cliente" name="cliente_id" required>
            <option value="">-- Selecciona un cliente --</option>
            <?php foreach ($clientes as $cliente) : ?>
                <option value="<?php echo $cliente->id; ?>" <?php echo isset($clienteSeleccionado) && $clienteSeleccionado->id == $cliente->id ? 'selected' : ''; ?>>
                    <?php echo $cliente->nombre; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit">Mostrar datos del cliente</button>
</form>

<?php if (isset($clienteSeleccionado)) : ?>
    <div>
        <h2>Datos del Cliente:</h2>
        <p><strong>Nombre:</strong> <?php echo $clienteSeleccionado->nombre; ?></p>
        <p><strong>Código de Brazalete:</strong> <?php echo $clienteSeleccionado->codigo_brazalete; ?></p>
        <!-- Agrega más campos si es necesario -->
    </div>
<?php endif; ?>
