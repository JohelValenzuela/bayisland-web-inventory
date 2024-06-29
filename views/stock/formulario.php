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
        <label for="producto">Producto del Pedido</label>  
                
        <select class="buscar" name="productoId" id="producto">
                
            <option selected value>-- Seleccione --</option>
                    
            <?php foreach($producto as $producto):  ?>
                <option  <?php echo $stock->productoId === $producto->id ? 'selected' : '' ?> value="<?php echo s($producto->id); ?>" ><?php echo s($producto->nombre . " | " . $producto->presentacion . " | " . $producto->unidad_empaque . " | " . $producto->cantidad  . " unidades | "); ?> </option>
            <?php endforeach; ?>
                    
        </select>
    </div>
    <div class="campo campo-separado w-20">
        <label for="cantidad" >Cantidad</label>
        <input name="cantidad" id="cantidad" type="text" placeholder="Cantidad"  value="<?php echo s($stock->cantidad) ?>"/>
    </div>
</div>








