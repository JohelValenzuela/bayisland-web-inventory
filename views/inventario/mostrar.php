<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Kardex</span>
    </div>
        
    <form class="form form-contenido form-botones">
        <a class="boton-exportar pdf" href="/fpdf/pdfInventario" target="_blank"> <i class="fa-solid fa-file-pdf"></i> PDF </a>  

      
        <button id="btnExportar" class="boton-exportar"> 
            <i class="fa-solid fa-file-excel"></i> EXCEL
        </button> 

    </form>

    <form class="form form-contenido form-botones">
        <div class="campo select-buscar">
            <select class="buscar" id="bodegaId" name="bodega">
            <option disabled selected value>-- Filtrar Bodega --</option>
                <option value="">Mostrar Todos</option>
                <?php foreach ($bodegas as $bodega) : ?>
                    <option value="<?php echo $bodega->nombre . " - " . $bodega->ubicacion; ?>"><?php echo $bodega->nombre . " - " . $bodega->ubicacion; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="campo select-buscar">
            <select class="buscar" id="productoId" name="producto" style="width: 100%;">
                <option disabled selected value>-- Filtrar Producto --</option>
                <option value="">Mostrar Todos</option>
                <?php foreach($producto as $producto):  ?>
                    <option value="<?php echo s($producto->nombre); ?>" ><?php echo s($producto->nombre); ?> </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="campo select-buscar">
            <select class="buscar" name="movimiento" id="movimiento" style="width: 100%;">
                <option disabled selected value>-- Filtrar Movimiento --</option>
                <option value="">Mostrar Todos</option>
                <option value="Entrada">Entrada</option>
                <option value="Salida" >Salida</option>                
            </select>

        </div>
    </form>

    <form action="/pedido/crear" class="form form-contenido form-tabla" method="POST" enctype="multipart/form-data">
 
        <table class="tabla" id="tabla">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Bodega</th>
                    <th>Referencia</th>
                    <th>Producto</th>
                    <th>Cantidad Anterior</th>
                    <th>Operación</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Cantidad Final</th>
                    <!-- <th>Estado</th> -->
                    <th>Creado Por</th>
                    <th>Fecha de Creación</th>
                </tr>
            </thead> 

            <tbody>
            <?php if(!empty($inventario)) { ?> 
                <?php foreach($inventario as $inventarios) : ?>
                    <?php
                        // Convertir la fecha de creación al formato dd-mm-yyyy
                        $fechaCreacion = new DateTime($inventarios->fechaCreacion);
                        $fechaCreacionFormateada = $fechaCreacion->format('d-m-Y H:i:s');
                    ?>
                <tr>
                    <td data-titulo="Id"><?php echo $inventarios->id; ?></td> <!--  ID  -->
                    <td data-titulo="Bodega"><?php echo $inventarios->bodega->nombre . '-' . $inventarios->bodega->ubicacion; ?></td> <!--  Referencia  -->
                    <td data-titulo="Referencia"><?php echo $inventarios->referencia; ?></td> <!--  Referencia  -->
                    <td data-titulo="Nombre"><?php echo $inventarios->producto->nombre; ?></td> <!--  Nombre  -->
                    <td data-titulo="Anterior"><?php echo $inventarios->cantidadAnterior; ?></td> <!--  Cantidad Anterior  -->
                    <td data-titulo="Operación"><?php echo $inventarios->operacion; ?></td> <!--  Nombre Operación  -->
                    <td data-titulo="Entrada">  <?php echo $inventarios->cantidadEntrada; ?></td> <!--  Cantidad Entrada  -->
                    <td data-titulo="Salida">  <?php echo $inventarios->cantidadSalida; ?></td> <!--  Cantidad Salida  -->
                    <td data-titulo="Total"><?php echo $inventarios->cantidadTotal; ?></td> <!--  Cantidad Total  -->
                    <td data-titulo="Creador"><?php echo $inventarios->usuario->nombre . " " . $inventarios->usuario->apellido  ; ?></td> <!--  Creador  -->
                    <td data-titulo="Creado"><?php echo $fechaCreacionFormateada; ?></td> <!-- Fecha Creación   -->
                </tr>
                <?php endforeach; ?>
            <?php } ?>
            <tbody>
        </table>
    </form>     



  </section>   