<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Reporte de Pasajeros</span>
    </div>

    <form class="form form-contenido form-botones">
        <a class="boton-exportar" href="/pasajeros/crear"> <i class="fa-regular fa-square-plus"></i> Reportar Pasajeros</a>
        <a class="boton-exportar pdf" href="/fpdf/pdfProducto" target="_blank"> <i class="fa-solid fa-file-pdf"></i> PDF</a>  


        <button id="btnExportar" class="boton-exportar">
            <i class="fa-solid fa-file-excel"></i> EXCEL
        </button> 

    </form>

    <section class="form form-contenido form-tabla" enctype="multipart/form-data">
        <table class="tabla table_id" id="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Reporta</th>
                    <th>Cantidad Guías</th>
                    <th>Cantidad Pasajeros</th>
                    <th>Cantidad NoShow</th>
                    <th>Ver Más</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($reportes as $reporte): ?> 
                    <?php
                        // Convertir la fecha de creación al formato dd-mm-yyyy
                        $fechaCreacion = new DateTime($reporte->fecha);
                        $fechaCreacionFormateada = $fechaCreacion->format('d-m-Y H:i:s');
                    ?>
                    <?php
                        $cantidad_pasajeros = $reporte->guia1_pasajeros + $reporte->guia2_pasajeros + $reporte->guia3_pasajeros + $reporte->guia4_pasajeros + $reporte->guia5_pasajeros + $reporte->pasajeros_muelle;
                    ?>
                <tr>
                    <td><?php echo $reporte->id; ?></td>
                    <td><?php echo $fechaCreacionFormateada; ?></td>
                    <td><?php echo $reporte->reportado_por->nombre; ?></td>
                    <td><?php echo count(explode(',',$reporte->guias_bote_ids)); ?></td>
                    <td><?php echo $cantidad_pasajeros; ?></td>
                    <td><?php echo $reporte->pasajeros_no_show; ?></td>
                    <td>
                        <div class="acciones-tabla">
                            <a class="boton-accion entrada" href="/pasajeros/gestionaReporte?id=<?php echo $reporte->id;?>">
                                <i class="fa-regular fa-eye accion toggle-on"></i>
                            </a>                  
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section> 
</section>   
