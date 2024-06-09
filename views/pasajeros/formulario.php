
    <fieldset class="fielset">
        <legend style="color: black;"><strong>DATOS DE GUÍA Y PASAJEROS</strong></legend>
              
        <?php $maxGuias = 5; // Define el número máximo de guías que quieres permitir ?>
        <?php  for ($i = 1; $i <= $maxGuias; $i++) { // Itera para generar los campos de guía ?>  
            <div class="div-flex">
                <div class="campo campo-separado w-40">
                    <label for="guia<?php echo $i; ?>_id">Guía <?php echo $i; ?>:</label>
                    <select name="guia<?php echo $i; ?>_id" id="guia<?php echo $i; ?>_id">
                        <option value="">Seleccionar Guía <?php echo $i; ?></option>
                        <?php foreach ($guias as $guia) : ?>
                            <option value="<?php echo $guia->id; ?>"><?php echo $guia->nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="campo campo-separado w-40">
                    <label for="guia<?php echo $i; ?>_nombre">Nombre del Guía:</label>
                    <input type="text" id="guia<?php echo $i; ?>_nombre" name="guia<?php echo $i; ?>_nombre" placeholder="Nombre del Guía">
                </div>
                <div class="campo campo-separado w-20">
                    <label for="guia<?php echo $i; ?>_pasajeros">Cantidad de Pasajeros:</label>
                    <input type="number" id="guia<?php echo $i; ?>_pasajeros" name="guia<?php echo $i; ?>_pasajeros" value="0">
                </div>
            </div>
        <?php } ?>
    </fieldset>

    <fieldset class="fielset"> 
        <legend style="color: black;"><strong>CANTIDAD DE PASAJEROS EN MUELLE Y NO-SHOW</strong></legend>
        <div class="div-flex">
            <div class="campo campo-separado w-40">
                <label for="guia_muelle">Guía Muelle:</label>
                <select name="guia_muelle" id="guia_muelle">
                    <option value="">Seleccionar Guía Muelle</option>
                    <?php foreach ($guias as $guia) : ?>
                        <option value="<?php echo $guia->id; ?>"><?php echo $guia->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="campo campo-separado w-40">
                <label for="guia_nombre_muelle">Nombre del Guía:</label>
                <input type="text" id="guia_nombre_muelle" name="guia_nombre_muelle" placeholder="Nombre del Guía">
            </div>
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

    <fieldset class="fielset"> 
        <legend style="color: black;"><strong>USUARIO QUE REPORTA</strong></legend>
        <div class="div-flex">
            <div class="campo campo-separado w-50">
                <label for="reportado_por_id">Reportado por:</label>
                <select name="reportado_por_id" id="reportado_por_id">
                    <option value="">Seleccionar Persona</option>
                    <?php foreach ($guias as $guia) : ?>
                        <option value="<?php echo $guia->id; ?>"><?php echo $guia->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="campo campo-separado w-50">
                <label for="reportado_por_nombre">Reportado por:</label>
                <input type="text" id="reportado_por_nombre" name="reportado_por_nombre" placeholder="Nombre de la persona que reporta">
            </div>
            
        </div>
    </fieldset>

    <fieldset class="fielset"> 
        <legend style="color: black;"><strong>GUÍAS EN BOTE</strong></legend>
        <div class="div-flex">
            <div class="campo campo-separado w-50">
                <label for="guias_bote_ids">Guías en el Bote:</label>
                <select name="guias_bote_ids[]" id="guias_bote_ids" multiple>
                    <?php foreach ($guias as $guia) : ?>
                        <option value="<?php echo $guia->id; ?>"><?php echo $guia->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </fieldset>

    <fieldset class="fielset"> 
        <legend style="color: black;"><strong>CAPITÁN DE BOTE</strong></legend>
        <div class="div-flex">
            <div class="campo campo-separado w-50">
                <label for="capitan_id">Capitán del Bote:</label>
                <select name="capitan_id" id="capitan_id">
                    <option value="">Seleccionar Capitán</option>
                    <?php foreach ($capitanes as $capitan) : ?>
                        <option value="<?php echo $capitan->id; ?>"><?php echo $capitan->nombre; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="campo campo-separado w-50">
                <label for="capitan_nombre">Capitán del Bote:</label>
                <input type="text" id="capitan_nombre" name="capitan_nombre" placeholder="Nombre del capitán del bote">
            </div>
        </div>
    </fieldset>