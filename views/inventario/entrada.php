<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Entrada de Producto</span>
    </div>

    <?php 
        include_once __DIR__ . "/../templates/alertas.php";
    ?>

    <form action="" class="form form-contenido" method="POST" value="Crear" enctype="multipart/form-data">
        <?php include __DIR__ . '/formulario.php' ?>

        <div class="campo campo-separado">
            <input type="submit" value="Crear entrada" class="boton boton-azul">
        </div>

    </form> 

</section>   