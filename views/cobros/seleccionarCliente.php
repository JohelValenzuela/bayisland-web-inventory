<section class="home-section">
    <div class="flex-carrito">
        <div class="home-content">
            <i class='bx bx-menu' ></i>
            <span class="text"> Crear Venta</span>
        </div>
        <div class="home-carrito">
            <a class="boton-exportar volver" style="margin-right: 1rem;" target="_blank" href="/fpdf/pdfGestionaVenta?id=<?php echo $ventaCliente->id ?? 0;?>">
                <i class="fa-solid fa-file-pdf"></i>   Generar PDF  
            </a>  
            <a href="/ventas" class="boton-exportar volver"> Regresar  <i class="fa-solid fa-person-walking-arrow-loop-left"></i> </a>
        </div>
    </div>

    <?php 
        include_once __DIR__ . "/../templates/alertas.php";
    ?>


    
    <form action="/cobros/seleccionarCliente" class="form form-contenido contenedor-flex" method="POST" value="Crear" enctype="multipart/form-data">
        <?php include __DIR__ . '/formularioCliente.php' ?>
    </form> 

</section>