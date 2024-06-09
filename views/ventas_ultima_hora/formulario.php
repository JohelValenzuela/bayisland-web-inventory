<div class="div-flex" style="height: 375px;">
    <div class="campo campo-separado w-35">
        <fieldset>
            <legend style="color: black;"><strong>INFORMACIÓN DE CLIENTE</strong></legend>
            
            <div class="campo campo-separado">
                <label for="nombre_persona">Nombre:</label>
                <input type="text" id="nombre_persona" name="nombre_persona" placeholder="Nombre de la persona" value="<?php echo s($venta->nombre_persona); ?>">
            </div>

            <div class="campo campo-separado">
                <label for="nacionalidad">Nacionalidad:</label>
                <input type="text" id="nacionalidad" name="nacionalidad" placeholder="Nacionalidad" value="<?php echo s($venta->nacionalidad); ?>">
            </div>

            <div class="campo campo-separado">
                <label for="cantidad_personas">Cantidad de Personas:</label>
                <input type="number" id="cantidad_personas" name="cantidad_personas" placeholder="Cantidad de personas" value="<?php echo s($venta->cantidad_personas); ?>">
            </div>
        </fieldset>
    </div>
    <div class="campo campo-separado w-35">
        <fieldset>
            <legend style="color: black;"><strong>INFORMACIÓN DE ENCARGADO</strong></legend>
            <div class="campo campo-separado">
                <label for="vendedor_nombre">Nombre del Vendedor:</label>
                <input type="text" id="vendedor_nombre" name="vendedor_nombre" placeholder="Nombre del vendedor" value="<?php echo s($venta->vendedor_nombre); ?>">
            </div>
            <div class="campo campo-separado">
                <label for="cobrador_nombre">Nombre del Cobrador:</label>
                <input type="text" id="cobrador_nombre" name="cobrador_nombre" placeholder="Nombre del cobrador" value="<?php echo s($venta->cobrador_nombre); ?>">
            </div>
        </fieldset>
    </div>
    <div class="campo campo-separado w-35">
        <fieldset>
            <legend style="color: black;"><strong>DETALLES DE LA VENTA</strong></legend>
            <div class="div-flex">
                <div class="campo campo-separado" style="margin-bottom: 3rem;">
                    <label for="total_dolares">Pago Dolares:</label>
                    <input type="number" step="0.01" id="total_pagar" name="total_dolares" placeholder="Total a pagar" value="<?php echo s($venta->total_dolares); ?>">
                </div>
                <div class="campo campo-separado" style="margin-bottom: 3rem;">
                    <label for="total_colones">Pago Colones:</label>
                    <input type="number" step="0.01" id="total_colones" name="total_colones" placeholder="Total a pagar" value="<?php echo s($venta->total_colones); ?>">
                </div>
            </div>
            <div class="campo campo-separado">
                <label for="total_pagar">Procesar Venta:</label>
                <input type="submit" class="boton-exportar formulario" value="Crear Venta">
            </div>
        </fieldset>
    </div>
</div>    