<section class="home-section">
    <div class="flex-carrito">
        <div class="home-content">
            <i class='bx bx-menu' ></i>
            <span class="text"> Actualizar Producto</span>
        </div>
        <div class="home-carrito">
            <a href="/producto" class="boton-exportar volver"> Regresar  <i class="fa-solid fa-person-walking-arrow-loop-left"></i> </a>
        </div>
    </div>


    <?php 
        include_once __DIR__ . "/../templates/alertas.php";
    ?>
    
    <form class="form form-contenido contenedor-flex" method="POST" enctype="multipart/form-data">
        <?php include __DIR__ . '/formulario.php' ?>

        <div class="campo campo-separado campo-flex">
            <label for="estado" >Estado</label>

            <select class="buscar" name="estado" id="estado">
                <option selected value>-- Seleccione --</option>
                <option value="<?php echo s($producto->estado = 'Activo') ?>">Activo</option>
                <option value="<?php echo s($producto->estado = 'Inactivo') ?>" >Inactivo</option>               
            </select>
        </div>
    </form> 
  </section>   