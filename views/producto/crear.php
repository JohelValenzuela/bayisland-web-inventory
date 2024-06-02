<section class="home-section">
    <div class="flex-carrito">
        <div class="home-content">
            <i class='bx bx-menu' ></i>
            <span class="text"> Crear Producto</span>
        </div>
        <div class="home-carrito">
            <a href="/producto" class="boton-exportar volver"> Regresar  <i class="fa-solid fa-person-walking-arrow-loop-left"></i> </a>
        </div>
    </div>

    <?php 
        include_once __DIR__ . "/../templates/alertas.php";
    ?>
    
    <form action="/producto/crear" class="form form-contenido contenedor-flex" method="POST" value="Crear" enctype="multipart/form-data">
        <?php include __DIR__ . '/formulario.php' ?>

    <div class="campo campo-separado">
        <input type="submit" value="Crear Producto" class="boton-exportar formulario">
    </div>

    </form> 

</section>