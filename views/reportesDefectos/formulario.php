
<form method="POST" action="/reportesDefectos/crear">

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
                <option value="">-- Seleccione Usuario --</option>
                <?php foreach ($usuarios as $usuario) : ?>
                    <option value="<?php echo $usuario->id; ?>"><?php echo $usuario->nombre . " " . $usuario->apellido; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="campo campo-separado w-40">
            <label for="producto_id">Producto</label>
            <select class="buscar" name="producto_id" id="producto_id">
                <option value="">-- Seleccione --</option>
                <?php foreach ($productos as $producto) : ?>
                    <option value="<?php echo $producto->id; ?>"><?php echo s($producto->nombre . " | " . $producto->presentacion . " | " . $producto->unidad_empaque . " | " . $producto->cantidad  . " unidades | "); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="campo campo-separado w-20">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" value="<?php echo s($reporte->cantidad) ?? 0; ?>">
        </div>
    </div>

    <div class="div-flex">
        <div class="campo campo-separado w-80">
            <label for="observacion">Observación</label>
            <input name="observacion" id="observacion"><?php echo s($reporte->observacion); ?></input>
        </div>
        <div class="campo campo-separado w-30">
            <label for="agregar">Crear Reporte</label>
            <input type="submit" value="Reportar Producto Defectuoso" class="boton-exportar formulario">
        </div>
    </div> 
</form>
