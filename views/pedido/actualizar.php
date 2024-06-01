<section class="home-section">
    <div class="flex-carrito">
        <div class="home-content">
            <i class='bx bx-menu' ></i>
            <span class="text"> Actualizar Pedido</span>
        </div>
        <div class="home-carrito">
            <a href="/pedido" class="boton-exportar volver"> Regresar  <i class="fa-solid fa-person-walking-arrow-loop-left"></i> </a>
        </div>
    </div>
    <?php 
        include_once __DIR__ . "/../templates/alertas.php";
    ?>

    <form action="" class="form form-contenido form-flex" method="POST" value="Crear" enctype="multipart/form-data">
        <?php include __DIR__ . '/formulario.php' ?>

        <div class="campo campo-separado">
            <input type="submit" value="Actualizar Pedido" class="boton-exportar">
        </div>

    </form> 

</section>   