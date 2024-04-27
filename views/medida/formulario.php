<div class="campo campo-separado campo-flex">
    <label for="nombre">Nombre de la Unidad de Medida</label>
    <input id="nombre" name="nombre" type="text" placeholder="Unidad de Medida. Ej: Litro, Kilo, Unidad" class="input" value="<?php echo s($medidas->nombre) ?>">
</div>

<div class="campo campo-separado campo-flex">
    <label for="sigla">Sigla para la Unidad de Medida</label>
    <input id="sigla" name="sigla" type="text" placeholder="Sigla Unidad de Medida. Ej: L, KG, UD" class="input" value="<?php echo s($medidas->sigla) ?>">
</div>

<div class="campo campo-separado campo-flex">
    <label for="estado" >Estado</label>

    <select class="buscar" name="estado" id="estado">
        <option selected value>-- Seleccione --</option>
        <option value="<?php echo s($medidas->estado = 'Activo') ?>">Activo</option>
        <option value="<?php echo s($medidas->estado = 'Inactivo') ?>" >Inactivo</option>               
    </select>
</div>

        
