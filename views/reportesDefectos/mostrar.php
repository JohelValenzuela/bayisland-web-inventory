<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Reportar Producto Dañado</span>
    </div>

    <form class="form form-contenido form-botones">
        <a class="boton-exportar" href="reportesDefectos/crear"> <i class="fa-regular fa-square-plus"></i> Reportar</a>
        <a class="boton-exportar pdf" href="/fpdf/pdfProducto" target="_blank"> <i class="fa-solid fa-file-pdf"></i> PDF</a>  


        <button id="btnExportar" class="boton-exportar">
            <i class="fa-solid fa-file-excel"></i> EXCEL
        </button> 

    </form>

    <form action="/reportesDefectos/crear" class="form form-contenido form-tabla" enctype="multipart/form-data">
        <table class="tabla table_id" id="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Reporta</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Observación</th>
                    <th>Fecha de Reporte</th>
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
                        <td><?php echo $reporte->producto->nombre . " " . $reporte->producto->presentacion; ?></td>
                        <td><?php echo $reporte->cantidad; ?></td>
                        <td><?php echo $reporte->observacion; ?></td>
                        <td><?php echo $fechaCreacionFormateada; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form> 
</section>   



