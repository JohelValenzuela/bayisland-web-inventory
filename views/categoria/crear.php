
<section class="home-section">
    <div class="flex-carrito">
        <div class="home-content">
            <i class='bx bx-menu' ></i>
            <span class="text"> Crear Categoría</span>
        </div>
        <div class="home-carrito">
            <a href="<?= $_SERVER["HTTP_REFERER"]?>" class="boton-exportar volver"> Regresar  <i class="fa-solid fa-person-walking-arrow-loop-left"></i> </a>
        </div>
    </div>

    <?php 
        include_once __DIR__ . "/../templates/alertas.php";
    ?>
    
    <form action="/categoria/crear" class="form form-contenido" method="POST" enctype="multipart/form-data">
        
    <div class="campo campo-separado">
        <label for="nombre">Nombre de Categoría</label>
        <input id="nombre" name="nombre" type="text" placeholder="Nombre Categoría" class="input" value="<?php echo s($categoria->nombre) ?>">
    </div>
    
        <div class="campo campo-separado">
            <input type="submit" value="Crear Categoría" class="boton boton-azul">
        </div>

    </form> 

</section>




