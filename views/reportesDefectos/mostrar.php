<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Productos Defectuosos</span>
    </div>

    <form class="form form-contenido form-botones">
        <a class="boton-exportar" href="reportesDefectos/crear"> <i class="fa-regular fa-square-plus"></i> Reportar Defecto</a>
        <a class="boton-exportar pdf" href="/fpdf/pdfDefectos" target="_blank"> <i class="fa-solid fa-file-pdf"></i> PDF</a>  


        <button id="btnExportar" class="boton-exportar">
            <i class="fa-solid fa-file-excel"></i> EXCEL
        </button> 

    </form>

    <section class="form form-contenido form-tabla" enctype="multipart/form-data">
        <table class="tabla table_id" id="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Reporta</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Observación</th>
                    <th>Fecha de Reporte</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reportes as $reporte) : ?>
                    <?php
                        // Convertir la fecha de creación al formato dd-mm-yyyy
                        $fechaCreacion = new DateTime($reporte->fecha_reporte);
                        $fechaCreacionFormateada = $fechaCreacion->format('d-m-Y H:i:s');
                    ?>
                    <tr>
                        <td><?php echo $reporte->id; ?></td>
                        <td><?php echo $reporte->usuario->nombre . " " . $reporte->usuario->apellido; ?></td>            
                        <td data-titulo="Producto o Receta">
                            <?php if ($reporte->producto_id !== 0 && $reporte->producto) {
                                echo  $reporte->producto->nombre . " " . $reporte->producto->presentacion;
                            } elseif ($reporte->receta_id !== 0 && $reporte->receta) {
                                echo $reporte->receta->nombre;
                            } else {
                                echo 'Nada';
                            } ?>
                        </td>                    
                        <td><?php echo $reporte->cantidad; ?></td>
                        <td><?php echo $reporte->observacion; ?></td>
                        <td><?php echo $fechaCreacionFormateada; ?></td>
                        <td>
                            <?php if ($reporte->estado == 'aprobado') : ?>
                                <a class="estado aceptado"> Aceptado </a>
                            <?php elseif($reporte->estado === 'rechazado'): ?>
                                <a class="estado rechazado"> Rechazado </a>
                            <?php else: ?>
                                <a class="estado pendiente"> Pendiente </a>
                            <?php endif ?>              
                        </td>
                        <td>
                        <?php if($_SESSION['rol'] == 'Administrador') : ?>
                            <?php if ($reporte->estado == 'pendiente') : ?>
                                <div class="acciones-tabla">
                                    <form method="POST" action="/reportesDefectos/aprobar" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $reporte->id; ?>">
                                        <button type="submit" class="boton-accion aprobar">
                                            <i class='bx bx-check accion'></i> Aprobar
                                        </button>
                                    </form>
                                    <form method="POST" action="/reportesDefectos/rechazar" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $reporte->id; ?>">
                                        <button type="submit" class="boton-accion eliminar">
                                            <i class='bx bx-x accion' ></i> Rechazar
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section> 
</section>   



