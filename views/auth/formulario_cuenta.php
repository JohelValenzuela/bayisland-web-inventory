<div class="campo campo-separado campo-flex">
            <label for="nombre">Nombre</label>
            <input id="nombre" name="nombre" type="text" placeholder="Nombre" class="input" value="<?php echo s($usuarios->nombre) ?>">
        </div>

        <div class="campo campo-separado campo-flex">
            <label for="apellido">Apellido</label>
            <input id="apellido" name="apellido" type="text" placeholder="Apellido" class="input" value="<?php echo s($usuarios->apellido) ?>" >
        </div>

        <div class="campo campo-separado campo-flex">
            <label for="correo" >Correo Electrónico</label>
            <input id="correo" name="correo" type="text" placeholder="Correo Electrónico" class="input" value="<?php echo s($usuarios->correo) ?>">
        </div>

        <!-- <div class="campo campo-separado">
            <label for="password" >Contraseña</label>
            <input id="password" name="password" type="password" placeholder="Contraseña" class="input">
        </div> -->

        <div class="campo campo-separado campo-flex">
            <label for="rol">Roles de Usuario</label>  
            
            <select class="buscar" name="rolId" id="rol">
            
                <option selected value>-- Seleccione --</option>
                
                <?php foreach($roles as $rol):  ?>
                    <option <?php echo $usuarios->rolId === $rol->id ? 'selected' : '' ?> value="<?php echo s($rol->id); ?>" ><?php echo s($rol->tipoRol); ?> </option>
                <?php endforeach; ?>
                
            </select>
        </div>

        <div class="campo campo-separado campo-flex">
          <label for="estado" >Estado</label>

          <select class="buscar" name="estado" id="estado">
              <option selected value>-- Seleccione --</option>
              <option value="<?php echo s($usuarios->estado = 'Activo') ?>">Activo</option>
              <option value="<?php echo s($usuarios->estado = 'Inactivo') ?>" >Inactivo</option>               
          </select>

        </div>

