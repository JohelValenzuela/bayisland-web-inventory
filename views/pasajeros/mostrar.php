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
                    <!-- <th>Guía 1</th>
                    <th>Pasajeros Guía 1</th>
                    <th>Guía 2</th>
                    <th>Pasajeros Guía 2</th>
                    <th>Guía 3</th>
                    <th>Pasajeros Guía 3</th>
                    <th>Guía 4</th>
                    <th>Pasajeros Guía 4</th>
                    <th>Guía 5</th>
                    <th>Pasajeros Guía 5</th>
                    <th>Guía Muelle</th>
                    <th>Pasajeros Guía Muelle</th>
                    <th>Pasajeros NoShow</th> -->
                    <th>Reporta</th>
                    <th>Cantidad Guías</th>
                    <th>Cantidad Pasajeros</th>
                    <th>Cantidad NoShow</th>
                    <th></th>
                    <!-- <th>Capitán</th> -->
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
                    <!-- <td><?php echo $reporte->guia1->nombre; ?></td>
                    <td><?php echo $reporte->guia1_pasajeros; ?></td>
                    <td><?php echo $reporte->guia2->nombre; ?></td>
                    <td><?php echo $reporte->guia2_pasajeros; ?></td>
                    <td><?php echo $reporte->guia3->nombre; ?></td>
                    <td><?php echo $reporte->guia3_pasajeros; ?></td>
                    <td><?php echo $reporte->guia4->nombre; ?></td>
                    <td><?php echo $reporte->guia4_pasajeros; ?></td>
                    <td><?php echo $reporte->guia5->nombre; ?></td>
                    <td><?php echo $reporte->guia5_pasajeros; ?></td>
                    <td><?php echo $reporte->guia_muelle->nombre; ?></td>
                    <td><?php echo $reporte->pasajeros_muelle; ?></td> -->
                    <td><?php echo $reporte->reportado_por->nombre; ?></td>
                    <td><?php echo $reporte->guias_bote_ids; ?></td>
                    <td><?php echo $cantidad_pasajeros; ?></td>
                    <td><?php echo $reporte->pasajeros_no_show; ?></td>
                    <!-- <td><?php echo $reporte->capitan->nombre; ?></td> -->
                    <td>
                        <div class="acciones-tabla">
                            <a class="boton-accion entrada" href="/pasajeros/gestionaReporte?id=<?php echo $reporte->id;?>">
                                <i class="fa-regular fa-pen-to-square accion"></i>    
                            </a>                  
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section> 
</section>   
