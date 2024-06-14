<section class="home-section">
    <div class="flex-carrito">
        <div class="home-content">
            <i class='bx bx-menu' ></i>
            <span class="text"> Gestionar Reporte de Pasajeros</span>
        </div>
        <div class="home-carrito">
            <a class="boton-exportar volver" style="margin-right: 1rem;" target="_blank" href="/fpdf/generarReportePDF?id=<?php echo $reporte->id;?>">
                <i class="fa-solid fa-file-pdf"></i>   Generar PDF  
            </a>  
            <a href="/pasajeros" class="boton-exportar volver"> Regresar  <i class="fa-solid fa-person-walking-arrow-loop-left"></i> </a>
        </div>
            
    </div>

    <?php 
        include_once __DIR__ . "/../templates/alertas.php";
    ?>

    

    <form action="generarReportePDF" class="form form-contenido form-flex" method="POST" value="Crear" enctype="multipart/form-data">
        <?php include __DIR__ . '/formularioReporte.php' ?>



    </form> 

</section>   