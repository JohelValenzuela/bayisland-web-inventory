<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Regalías</span>
    </div>

    <form class="form form-contenido form-botones">
        <a class="boton-exportar" href="/regalias/crear"> <i class="fa-regular fa-square-plus"></i> Reportar Regalía</a>
        <a class="boton-exportar pdf" href="/fpdf/pdfRegalias" target="_blank"> <i class="fa-solid fa-file-pdf"></i> PDF</a>  


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
                <?php foreach($regalias as $regalia): ?>
                    <?php
                        // Convertir la fecha de creación al formato dd-mm-yyyy
                        $fechaCreacion = new DateTime($regalia->fecha_regalia);
                        $fechaCreacionFormateada = $fechaCreacion->format('d-m-Y H:i:s');
                    ?>
                <tr>
                    <td><?php echo $regalia->id; ?></td>
                    <td><?php echo $regalia->usuario->nombre . " " . $regalia->usuario->apellido ; ?></td>
                    <td><?php echo $regalia->producto->nombre . " " . $regalia->producto->presentacion  ; ?></td>
                    <td><?php echo $regalia->cantidad; ?></td>
                    <td><?php echo $regalia->observacion; ?></td>
                    <td><?php echo $fechaCreacionFormateada; ?></td>
                    <td>
                        <?php if ($regalia->estado == 'aprobado') : ?>
                            <a class="estado aceptado"> Aceptado </a>
                        <?php elseif($regalia->estado === 'rechazado'): ?>
                            <a class="estado rechazado"> Rechazado </a>
                        <?php else: ?>
                            <a class="estado pendiente"> Pendiente </a>
                        <?php endif ?>              
                    </td>
                    <td>
                        <?php if ($regalia->estado == 'pendiente') : ?>
                            <div class="acciones-tabla">
                                <form method="POST" action="/regalias/aprobar" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $regalia->id; ?>">
                                    <button type="submit" class="boton-accion aprobar">
                                        <i class='bx bx-check accion'></i> Aprobar
                                    </button>
                                </form>
                                <form method="POST" action="/regalias/rechazar" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $regalia->id; ?>">
                                    <button type="submit" class="boton-accion eliminar">
                                       <i class='bx bx-x accion' ></i> Rechazar
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section> 
</section>   
