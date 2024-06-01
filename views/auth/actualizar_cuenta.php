<section class="home-section">
    <div class="flex-carrito">
        <div class="home-content">
            <i class='bx bx-menu' ></i>
            <span class="text"> Actualizar Usuario</span>
        </div>
        <div class="home-carrito">
            <a href="/auth/mostrar" class="boton-exportar volver"> Regresar  <i class="fa-solid fa-person-walking-arrow-loop-left"></i> </a>
        </div>
    </div>

    <?php 
      include_once __DIR__ . "/../templates/alertas.php";
    ?>
    
    <form class="form form-contenido contenedor-flex" method="POST" enctype="multipart/form-data">
        <?php include __DIR__ . '/formulario_cuenta.php' ?>

        <div class="campo campo-separado">
            <input type="submit" value="Actualizar Usuario" class="boton boton-azul">
        </div>

    </form> 

</section>

