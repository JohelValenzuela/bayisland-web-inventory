<section class="home-section">
    <div class="flex-carrito">
        <div class="home-content">
            <i class='bx bx-menu' ></i>
            <span class="text"> Gestionar Referencia de Pedido</span>
        </div>
        <div class="home-carrito">
            <a href="<?= $_SERVER["HTTP_REFERER"]?>" class="boton-exportar volver"> Regresar  <i class="fa-solid fa-person-walking-arrow-loop-left"></i> </a>
        </div>
    </div>

    <?php 
        include_once __DIR__ . "/../templates/alertas.php";
    ?>

    <form action="/pedido/gestionaReferencia" class="form form-contenido form-flex" method="POST" value="Crear" enctype="multipart/form-data">
        <?php include __DIR__ . '/formularioReferencia.php' ?>

        <div class="campo campo-separado">
            <input type="submit" value="Actualizar Pedido" class="boton-exportar">
        </div>

    </form> 


</section>   