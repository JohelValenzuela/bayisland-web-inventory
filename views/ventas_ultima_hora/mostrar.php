<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Ventas de Última Hora</span>
    </div>

    <form class="form form-contenido form-botones">
        <a class="boton-exportar" href="/ventas_ultima_hora/crear"> <i class="fa-regular fa-square-plus"></i> Crear Venta</a>
        <a class="boton-exportar pdf" href="/fpdf/pdfVentasUltimaHora" target="_blank"> <i class="fa-solid fa-file-pdf"></i> PDF</a>  


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
                    <th>Nombre Cliente</th>
                    <th>Nacionalidad</th>
                    <th>Cantidad de Personas</th>
                    <th>Vendedor</th>
                    <th>Cobrador</th>
                    <th>Total Dólares</th>
                    <th>Total Colones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($venta as $ventas): ?>
                    <?php
                        // Convertir la fecha de creación al formato dd-mm-yyyy
                        $fechaCreacion = new DateTime($ventas->fecha);
                        $fechaCreacionFormateada = $fechaCreacion->format('d-m-Y H:i:s');
                    ?>
                <tr>
                    <td><?php echo $ventas->id; ?></td>
                    <td><?php echo $fechaCreacionFormateada; ?></td>
                    <td><?php echo $ventas->nombre_persona; ?></td>
                    <td><?php echo $ventas->nacionalidad; ?></td>
                    <td><?php echo $ventas->cantidad_personas; ?></td>
                    <td><?php echo $ventas->vendedor_nombre; ?></td>
                    <td><?php echo $ventas->cobrador_nombre; ?></td>
                    <td><?php echo $ventas->total_dolares; ?></td>
                    <td><?php echo $ventas->total_colones; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section> 
</section>   
