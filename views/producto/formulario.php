<div class="div-flex" style="height: 290px;">
    <div class="campo campo-separado w-50">
        <fieldset>
            <legend style="color: black;"><strong>INFORMACIÓN DE PRODUCTO</strong></legend>
            <div class="campo campo-separado">
                <label for="categoria">Categoría del Producto</label>  
                <select class="buscar" id="categoriaId" name="categoriaId" style="width: 100%;">
                
                <option disabled selected value>-- Seleccione --</option>
                    
                    <?php foreach($categoria as $categoria):  ?>
                        <option <?php echo $producto->categoriaId === $categoria->id ? 'selected' : '' ?> value="<?php echo s($categoria->id); ?>" ><?php echo s($categoria->nombre); ?> </option>
                    <?php endforeach; ?>
                    
                </select>
            </div>
            <div class="campo campo-separado">
                <label for="nombre">Nombre Producto</label>
                <input name="nombre" id="nombre" type="text" placeholder="Nombre del Producto"  value="<?php echo s($producto->nombre) ?>"/>
            </div>
        </fieldset>
    </div>

    <div class="campo campo-separado w-50">
        <fieldset>
            <legend style="color: black;"><strong>DETALLE DE PRESENTACIÓN</strong></legend>
            <div class="campo campo-separado">
                <label for="presentacion">Presentación de Producto</label>
                <select class="buscar" name="presentacion" id="presentacion" style="width: 100%;">
                    <option disabled selected value>-- Seleccione --</option>
                    <option <?php echo $producto->presentacion === 'Caja' ? 'selected' : '' ?> value="Caja">Caja</option>
                    <option <?php echo $producto->presentacion === 'Botella' ? 'selected' : '' ?> value="Botella">Botella</option>
                    <option <?php echo $producto->presentacion === 'Lata' ? 'selected' : '' ?> value="Lata">Lata</option>
                    <option <?php echo $producto->presentacion === 'Bolsa' ? 'selected' : '' ?> value="Bolsa">Bolsa</option>
                </select>
            </div>

            <div class="campo campo-separado">
                <label for="cantidadPresentacion" >Cantidad Presentación</label>
                <input  name="cantidadPresentacion" id="cantidadPresentacion" type="float" placeholder="Cantidad de Presentación, Ej: 355ml - 1.75L, 250gr"  value="<?php echo s($producto->cantidadPresentacion) ?>"/>
            </div>
        </fieldset>
    </div>
</div>
        
<div class="div-flex" style="height: 290px;">
    <div class="campo campo-separado w-50">
        <fieldset>
            <legend style="color: black;"><strong>TIPO DE PRESENTACIÓN</strong></legend>
            <div class="campo campo-separado">
                <label for="unidad_empaque">Unidad / Empaque</label>
                <select class="buscar" name="unidad_empaque" id="unidad_empaque" style="width: 100%;">
                    <option disabled selected value>-- Seleccione --</option>
                    <option <?php echo $producto->unidad_empaque === 'Unidad' ? 'selected' : '' ?> value="Unidad">Unidad</option>
                    <option <?php echo $producto->unidad_empaque === 'Empaque' ? 'selected' : '' ?> value="Empaque">Empaque</option>
                </select>
            </div>

            <div class="campo campo-separado">
                <label for="cantidad" >Cantidad de Unidades por Empaque</label>
                <input  name="cantidad" id="cantidad" type="number" placeholder="Cantidad"  value="<?php echo s($producto->cantidad) ?>"/>
            </div>     
        </fieldset>
    </div>  
    <div class="campo campo-separado w-50">
        <fieldset>
            <legend style="color: black;"><strong>MEDIDA DE PRODUCTO</strong></legend>
            <div class="campo campo-separado">
                <label for="medidas" >Unidad de Medida</label>
                <select class="buscar" name="medidaId" id="medidas" style="width: 100%;">              
                <option selected value>-- Seleccione --</option>            
                <?php foreach($medidas as $medida):  ?>
                    <option <?php echo $producto->medidaId === $medida->id ? 'selected' : '' ?> value="<?php echo s($medida->id); ?>" ><?php echo s($medida->nombre); ?> </option>
                <?php endforeach; ?>            
                </select>
            </div>
            <div class="campo campo-separado">
                <label for="totalMedida" >Total de Medida</label>
                <input  name="totalMedida" id="totalMedida" type="number" placeholder="Precio del Producto"  value="<?php echo s($producto->totalMedida) ?? 0 ?>"/>
            </div>
        </fieldset>
    </div>
    <div class="campo campo-separado w-50">
        <fieldset>
            <legend style="color: black;"><strong>PRECIO DEL PRODUCTO</strong></legend>
            <div class="campo campo-separado">
                <label for="precioUnidad" >Precio Producto</label>
                <input  name="precioUnidad" id="precioUnidad" type="number" placeholder="Precio del Producto"  value="<?php echo s($producto->precioUnidad) ?? 0 ?>"/>
            </div>
            <div class="campo campo-separado">
                <label for="precioMedida" >Precio por Medida</label>
                <input  name="precioMedida" id="precioMedida" type="number" placeholder="Precio por Medida"  value="<?php echo s($producto->precioMedida) ?? 0 ?>"/>
            </div>
        </fieldset>
    </div>  
</div>   
<div class="div-flex" style="height: 0px;"></div>
    <div class="campo campo-separado w-50" style="height: 100px;">
        <fieldset>
            <legend style="color: black;"><strong>CREAR PRODUCTO</strong></legend>
            <div class="campo campo-separado">
                <input type="submit" value="Crear Producto" class="boton-exportar formulario">
            </div>
        </fieldset>
    </div>
</div>   