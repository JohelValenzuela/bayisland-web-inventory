<?php
?>
<div class="campo campo-separado">
    <label for="nombre">Nombre de Categoría</label>
    <input id="nombre" name="nombre" type="text" placeholder="Nombre Categoría" class="input" value="<?php echo s($categoria->nombre) ?>">
</div>

<div class="campo campo-separado">
    <label for="estado" >Estado</label>
    <select class="buscar" name="estado" id="estado" name="estado" data-dropdown>
            <option selected value>-- Seleccione --</option>
            <option value="<?php echo s($categoria->estado = 'Activo') ?>">Activo</option>
            <option value="<?php echo s($categoria->estado = 'Inactivo') ?>" >Inactivo</option>               
    </select>
</div>
