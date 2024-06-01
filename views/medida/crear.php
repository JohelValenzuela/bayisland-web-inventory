<section class="home-section">
    <div class="flex-carrito">
        <div class="home-content">
            <i class='bx bx-menu' ></i>
            <span class="text"> Crear Unidad de Medida</span>
        </div>
        <div class="home-carrito">
            <a href="/medida" class="boton-exportar volver"> Regresar  <i class="fa-solid fa-person-walking-arrow-loop-left"></i> </a>
        </div>
    </div>

    <?php 
        include_once __DIR__ . "/../templates/alertas.php";
    ?>

    <form action="" class="form form-contenido contenedor-flex" method="POST" value="Crear" enctype="multipart/form-data">
        
        <div class="campo campo-separado campo-flex">
            <label for="nombre">Nombre de la Unidad de Medida</label>
            <input id="nombre" name="nombre" type="text" placeholder="Unidad de Medida. Ej: Litro, Kilo, Unidad" class="input" value="<?php echo s($medidas->nombre) ?>">
        </div>

                
        <div class="campo campo-separado campo-flex">
            <label for="sigla">Sigla para la Unidad de Medida</label>
            <input id="sigla" name="sigla" type="text" placeholder="Sigla Unidad de Medida. Ej: L, KG, UD" class="input" value="<?php echo s($medidas->sigla) ?>">
        </div>

        <div class="campo campo-separado">
            <input type="submit" value="Crear entrada" class="boton boton-azul">
        </div>

    </form> 

</section>   