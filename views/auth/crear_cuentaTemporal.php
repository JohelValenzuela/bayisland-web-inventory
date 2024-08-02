<section class="home-section">
    <div class="flex-carrito">
        <div class="home-content">
            <i class='bx bx-menu' ></i>
            <span class="text"> Crear Usuario Temporal</span>
        </div>
        <div class="home-carrito">
            <a href="/auth/mostrarTemporal" class="boton-exportar volver"> Regresar  <i class="fa-solid fa-person-walking-arrow-loop-left"></i> </a>
        </div>
    </div>

    <?php 
      include_once __DIR__ . "/../templates/alertas.php";
    ?>
    
    <form action="/auth/crear_cuentaTemporal" class="form form-contenido contenedor-flex" method="POST" enctype="multipart/form-data">
        <?php include __DIR__ . '/formulario_cuentaTemporal.php' ?>

        <div class="campo campo-separado">
            <input type="submit" value="Crear Usuario" class="boton-exportar formulario">
        </div>
        
    </form> 

    

</section>
