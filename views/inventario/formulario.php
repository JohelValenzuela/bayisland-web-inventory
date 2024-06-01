
<div class="campo campo-separado">
    <label for="producto">Producto del Pedido</label>  
            
    <select name="productoId" id="producto">
            
        <option selected value>-- Seleccione --</option>
                
        <?php foreach($producto as $producto):  ?>
            <option <?php echo $inventario->productoId === $producto->id ? 'selected' : '' ?> value="<?php echo s($producto->id); ?>" ><?php echo s($producto->nombre . " | " . $producto->presentacion . " | " . $producto->unidad_empaque . " | " . $producto->cantidad  . " unidades | "); ?> </option>
        <?php endforeach; ?>
                
    </select>
</div>

<div class="campo campo-separado">
    <label for="cantidad" >Cantidad</label>
    <input name="cantidad" id="cantidad" type="text" placeholder="Cantidad"  value="<?php echo s($inventario->cantidad) ?>"/>
</div>

<div class="campo campo-separado">
    <label for="estado" >Estado</label>

    <select name="estado" id="estado">
        <option selected value>-- Seleccione --</option>
        <option value="<?php echo s($inventario->estado = 'Activo') ?>">Activo</option>
        <option value="<?php echo s($inventario->estado = 'Inactivo') ?>" >Inactivo</option>               
    </select>
</div>


