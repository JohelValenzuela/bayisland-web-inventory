<div class="campo campo-separado">
        <label for="nombre">Nombre de Categoría</label>
        <input id="nombre" name="nombre" type="text" placeholder="Nombre Receta" class="input" value="<?php echo s($recetas->nombre) ?? '' ?>">
</div>

<div class="campo campo-separado">
        <label for="observacion">Detalles de la Receta</label>
        <input id="observacion" name="observacion" type="text" placeholder="Detalle Receta" class="input" value="<?php echo s($recetas->observacion) ?>">
</div>
