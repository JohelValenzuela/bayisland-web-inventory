<form method="POST" action="/regalias/crear">

    <div class="div-flex">
        <div class="campo campo-separado w-40">
            <label for="bodegaId">Seleccione un Almacén</label>
            <select class="buscar" name="bodegaId" id="bodegaId">
                <option value="">-- Seleccione Bodega --</option>
                <?php foreach ($bodegas as $bodega) : ?>
                    <option value="<?php echo $bodega->id; ?>"><?php echo $bodega->nombre . " - " . $bodega->ubicacion; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="campo campo-separado w-40">
            <label for="usuario_id">Usuario que reporta</label>
            <select class="buscar" name="usuario_id" id="usuario_id">
                <option value="">-- Seleccione --</option>
                <?php foreach ($usuarios as $usuario) : ?>
                    <option value="<?php echo $usuario->id; ?>"><?php echo $usuario->nombre . " " . $usuario->apellido; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="campo campo-separado w-40">
            <label for="productoOrReceta">Producto o Receta</label>
            <select class="buscar" name="productoOrReceta" id="productoOrReceta">
                <option value="">-- Seleccione --</option>
                <?php foreach ($productos as $producto) : ?>
                    <option value="producto-<?php echo $producto->id; ?>"><?php echo s($producto->nombre . " | " . $producto->presentacion . " | " . $producto->unidad_empaque . " | " . $producto->cantidad  . " unidades | "); ?></option>
                <?php endforeach; ?>
                <?php foreach ($recetas as $receta) : ?>
                    <option value="receta-<?php echo $receta->id; ?>"><?php echo s($receta->nombre); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="campo campo-separado w-20">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" value="<?php echo s($regalia->cantidad) ?? 0; ?>">
        </div>
    </div>

    <div class="div-flex">
        <div class="campo campo-separado w-80">
            <label for="observacion">Observación</label>
            <input name="observacion" id="observacion"><?php echo s($regalia->observacion); ?></input>
        </div>
        <div class="campo campo-separado w-30">
            <label for="agregar">Crear Reporte de Regalía</label>
            <input type="submit" value="Reportar Regalía" class="boton-exportar formulario">
        </div>
    </div> 
</form>
