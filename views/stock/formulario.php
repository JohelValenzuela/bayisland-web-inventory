
<div class="campo campo-separado campo-flex">
    <label for="producto">Producto del Pedido</label>  
            
    <select class="buscar" name="productoId" id="producto">
            
        <option selected value>-- Seleccione --</option>
                
        <?php foreach($producto as $producto):  ?>
            <option  <?php echo $stock->productoId === $producto->id ? 'selected' : '' ?> value="<?php echo s($producto->id); ?>" ><?php echo s($producto->nombre . " | " . $producto->presentacion . " | " . $producto->unidad_empaque . " | " . $producto->cantidad  . " unidades | "); ?> </option>
        <?php endforeach; ?>
                
    </select>
</div>

<div class="campo campo-separado campo-flex">
    <label for="cantidad" >Cantidad</label>
    <input name="cantidad" id="cantidad" type="text" placeholder="Cantidad"  value="<?php echo s($stock->cantidad) ?>"/>
</div>
