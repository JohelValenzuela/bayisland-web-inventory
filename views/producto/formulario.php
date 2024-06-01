        <div class="campo campo-separado campo-flex">
            <label for="categoria">Categoría del Producto</label>  
            <select class="buscar" id="categoriaId" name="categoriaId" style="width: 100%;">
            
            <option disabled selected value>-- Seleccione --</option>
                
                <?php foreach($categoria as $categoria):  ?>
                    <option <?php echo $producto->categoriaId === $categoria->id ? 'selected' : '' ?> value="<?php echo s($categoria->id); ?>" ><?php echo s($categoria->nombre); ?> </option>
                <?php endforeach; ?>
                
            </select>
        </div>
        
        <div class="campo campo-separado campo-flex">
            <label for="nombre">Nombre Producto</label>
            <input name="nombre" id="nombre" type="text" placeholder="Nombre del Producto"  value="<?php echo s($producto->nombre) ?>"/>
        </div>

        <div class="campo campo-separado campo-flex">
            <label for="presentacion" >Presentación de Producto</label>
            <input  name="presentacion" id="presentacion" type="text" placeholder="Presentación del Producto, Ej: Caja - Botella - Lata"  value="<?php echo s($producto->presentacion) ?>"/>
        </div>

        <div class="campo campo-separado campo-flex">
            <label for="cantidadPresentacion" >Cantidad Presentación</label>
            <input  name="cantidadPresentacion" id="cantidadPresentacion" type="float" placeholder="Cantidad de Presentación"  value="<?php echo s($producto->cantidadPresentacion) ?>"/>
        </div>

        <div class="campo campo-separado campo-flex">
            <label for="unidad_empaque" >Unidad / Empaque</label>
            <input  name="unidad_empaque" id="unidad_empaque" type="text" placeholder="Unidad o Empaque"  value="<?php echo s($producto->unidad_empaque) ?>"/>
        </div>

        <div class="campo campo-separado campo-flex">
            <label for="cantidad" >Cantidad</label>
            <input  name="cantidad" id="cantidad" type="number" placeholder="Cantidad"  value="<?php echo s($producto->cantidad) ?>"/>
        </div>

        <div class="campo campo-separado campo-flex">
            <label for="totalMedida" >Total de Medida</label>
            <input  name="totalMedida" id="totalMedida" type="number" placeholder="Precio del Producto"  value="<?php echo s($producto->totalMedida) ?>"/>
        </div>

        <div class="campo campo-separado campo-flex">
            <label for="medidas" >Unidad de Medida</label>
            <select class="buscar" name="medidaId" id="medidas" style="width: 100%;">              
              <option selected value>-- Seleccione --</option>            
              <?php foreach($medidas as $medida):  ?>
                <option <?php echo $producto->medidaId === $medida->id ? 'selected' : '' ?> value="<?php echo s($medida->id); ?>" ><?php echo s($medida->nombre); ?> </option>
              <?php endforeach; ?>            
            </select>
        </div>

        <div class="campo campo-separado campo-flex">
            <label for="precioUnidad" >Precio Producto</label>
            <input  name="precioUnidad" id="precioUnidad" type="number" placeholder="Precio del Producto"  value="<?php echo s($producto->precioUnidad) ?>"/>
        </div>

        <div class="campo campo-separado campo-flex">
            <label for="precioMedida" >Precio por Medida</label>
            <input  name="precioMedida" id="precioMedida" type="number" placeholder="Precio por Medida"  value="<?php echo s($producto->precioMedida) ?>"/>
        </div>

        

      

        
      
