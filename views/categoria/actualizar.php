<section class="home-section">
    <div class="flex-carrito">
        <div class="home-content">
            <i class='bx bx-menu' ></i>
            <span class="text"> Actualizar Categoría</span>
        </div>
        <div class="home-carrito">
            <a href="/categoria" class="boton-exportar volver"> Regresar  <i class="fa-solid fa-person-walking-arrow-loop-left"></i> </a>
        </div>
    </div>

    <?php 
        include_once __DIR__ . "/../templates/alertas.php";
    ?>
    
    <form class="form form-contenido" method="POST" enctype="multipart/form-data">
        <?php include __DIR__ . '/formulario.php' ?>
    
        <div class="campo campo-separado">
            <input type="submit" value="Actualizar Categoría" class="boton boton-azul">
        </div>

    </form> 



</section>
