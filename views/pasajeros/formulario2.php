<form method="POST" class="formulario">

    <fieldset class="form-contenido">
        <div class="div-flex">
            <div class="campo campo-separado w-20">
                <label for="guia1_id">Guía 1:</label>
                <select name="guia1_id" id="guia1_id">
                    <option value="">Seleccionar Guía 1</option>
                    <?php foreach ($guias as $guia) : ?>
                        <option value="<?php echo $guia->id; ?>"><?php echo $guia->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="campo campo-separado w-15">
                <label for="guia1_nombre">Nombre del Guía:</label>
                <input type="text" id="guia1_nombre" name="guia1_nombre" placeholder="Nombre del Guía">
            </div>
            <div class="campo campo-separado w-15">
                <label for="guia1_pasajeros">Cantidad de Pasajeros:</label>
                <input type="number" id="guia1_pasajeros" name="guia1_pasajeros" value="0">
            </div>
        </div>   

        <div class="div-flex">
            <div class="campo campo-separado w-20">
                <label for="guia2_id">Guía 2:</label>
                <select name="guia2_id" id="guia2_id">
                    <option value="">Seleccionar Guía 2</option>
                    <?php foreach ($guias as $guia) : ?>
                        <option value="<?php echo $guia->id; ?>"><?php echo $guia->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
                <div class="campo campo-separado w-15">
                <label for="guia2_nombre">Nombre del Guía:</label>
                <input type="text" id="guia2_nombre" name="guia2_nombre" placeholder="Nombre del Guía">
            </div>
            <div class="campo campo-separado w-15">
                <label for="guia2_pasajeros">Cantidad de Pasajeros:</label>
                <input type="number" id="guia2_pasajeros" name="guia2_pasajeros" value="0">
            </div>
        </div>

        <div class="div-flex">
            <div class="campo campo-separado w-40">
                <label for="guia3_id">Guía 3:</label>
                <select name="guia3_id" id="guia3_id">
                    <option value="">Seleccionar Guía 3</option>
                    <?php foreach ($guias as $guia) : ?>
                        <option value="<?php echo $guia->id; ?>"><?php echo $guia->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="campo campo-separado w-40">
                <label for="guia1_nombre">Nombre del Guía:</label>
                <input type="text" id="guia3_nombre" name="guia3_nombre" placeholder="Nombre del Guía">
            </div>
            <div class="campo campo-separado w-20">
                <label for="guia3_pasajeros">Cantidad de Pasajeros:</label>
                <input type="number" id="guia3_pasajeros" name="guia3_pasajeros" value="0">
            </div>
        </div>

        <div class="div-flex">
            <div class="campo campo-separado w-40">
                <label for="guia4_id">Guía 4:</label>
                <select name="guia4_id" id="guia4_id">
                    <option value="">Seleccionar Guía 4</option>
                    <?php foreach ($guias as $guia) : ?>
                        <option value="<?php echo $guia->id; ?>"><?php echo $guia->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="campo campo-separado w-40">
                <label for="guia1_nombre">Nombre del Guía:</label>
                <input type="text" id="guia4_nombre" name="guia4_nombre" placeholder="Nombre del Guía">
            </div>
            <div class="campo campo-separado w-20">
                <label for="guia4_pasajeros">Cantidad de Pasajeros:</label>
                <input type="number" id="guia4_pasajeros" name="guia4_pasajeros" value="0">
            </div>
        </div>

        <div class="div-flex">
            <div class="campo campo-separado w-40">
                <label for="guia5_id">Guía 5:</label>
                <select name="guia5_id" id="guia5_id">
                    <option value="">Seleccionar Guía 5</option>
                    <?php foreach ($guias as $guia) : ?>
                        <option value="<?php echo $guia->id; ?>"><?php echo $guia->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="campo campo-separado w-40">
                <label for="guia1_nombre">Nombre del Guía:</label>
                <input type="text" id="guia5_nombre" name="guia5_nombre" placeholder="Nombre del Guía">
            </div>
            <div class="campo campo-separado w-20">
                <label for="guia5_pasajeros">Cantidad de Pasajeros:</label>
                <input type="number" id="guia5_pasajeros" name="guia5_pasajeros" value="0">
            </div>
        </div>
    </fieldset>

    <fieldset class="form-contenido"> 
        <div class="div-flex">
            <div class="campo campo-separado w-20">
                <label for="pasajeros_muelle">Pasajeros en Muelle:</label>
                <input type="number" id="pasajeros_muelle" name="pasajeros_muelle" value="0">
            </div>

            <div class="campo campo-separado w-20">
                <label for="pasajeros_no_show">Pasajeros No Show:</label>
                <input type="number" id="pasajeros_no_show" name="pasajeros_no_show" value="0">
            </div>
        </div>
    </fieldset>

    <fieldset class="form-contenido"> 
        <div class="div-flex">
            <div class="campo campo-separado w-40">
                <label for="reportado_por_id">Reportado por:</label>
                <select name="reportado_por_id" id="reportado_por_id">
                    <option value="">Seleccionar Persona</option>
                    <?php foreach ($guias as $guia) : ?>
                        <option value="<?php echo $guia->id; ?>"><?php echo $guia->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="campo campo-separado w-40">
                <label for="reportado_por_id">Reportado por:</label>
                <input type="text" id="reportado_por_id" name="reportado_por_id" placeholder="Nombre de la persona que reporta">
            </div>
            
        </div>
    </fieldset>

    <fieldset class="form-contenido"> 
        <div class="div-flex">
            <div class="campo campo-separado w-40">
                <label for="guias_bote_ids">Guías en el Bote:</label>
                <select name="guias_bote_ids[]" id="guias_bote_ids" multiple>
                    <?php foreach ($guias as $guia) : ?>
                        <option value="<?php echo $guia->id; ?>"><?php echo $guia->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </fieldset>

    <fieldset class="form-contenido"> 
        <div class="div-flex">
            <div class="campo campo-separado w-40">
                <label for="capitan_id">Capitán del Bote:</label>
                <select name="capitan_id" id="capitan_id">
                    <option value="">Seleccionar Capitán</option>
                    <?php foreach ($guias as $guia) : ?>
                        <option value="<?php echo $guia->id; ?>"><?php echo $guia->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="campo campo-separado w-40">
                <label for="capitan_id">Capitán del Bote:</label>
                <input type="text" id="capitan_id" name="capitan_id" placeholder="Nombre del capitán del bote">
            </div>
        </div>
    </fieldset>  

    <input type="submit" class="boton" value="Crear Reporte">
</form>