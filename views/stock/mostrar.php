<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Control de Stock</span>
    </div>
    <form class="form form-contenido form-botones">
        <?php if($_SESSION['rol'] == 'Administrador') : ?>
        <a class="boton-exportar" href="/stock/nuevoStock"> <i class="fa-regular fa-square-plus"></i> Agregar</a>
        <a class="boton-exportar" href="/stock/nuevaSalida"> <i class="fa-regular fa-square-minus"></i> Retirar</a>
        <?php endif ?>
        <a class="boton-exportar pdf" href="/fpdf/pdfStock" target="_blank"> <i class="fa-solid fa-file-pdf"></i> PDF </a>  

        
        <button id="btnExportar" class="boton-exportar"> 
            <i class="fa-solid fa-file-excel"></i> EXCEL
        </button>  
    </form>

    <?php 
      include_once __DIR__ . "/../templates/alertas.php";
    ?>

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

    <form action="" class="form form-contenido form-tabla" method="POST" enctype="multipart/form-data"> 
        <table class="tabla" id="tabla">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Bodega</th>
                    <th>Producto</th>
                    <th>Presentación</th>
                    <th>Cantidad</th>
                    <th>Movimiento</th>
                    <th>Creado Por</th>
                    <th>Fecha de Creación</th>
                </tr>
            </thead>

            <tbody>
                <?php if(!empty($stock)) { ?> 
                    <?php foreach($stock as $stock) : ?>
                        <?php if($stock->cantidad > 0) :?>
                            <?php
                                // Convertir la fecha de creación al formato dd-mm-yyyy
                                $fechaCreacion = new DateTime($stock->fechaCreacion);
                                $fechaCreacionFormateada = $fechaCreacion->format('d-m-Y H:i:s');
                            ?>
                            <tr>
                                <td data-titulo="Id"><?php echo $stock->id; ?></td> <!--  ID  -->
                                <td data-titulo="Bodega"><?php echo $stock->bodega->nombre . '-' . $stock->bodega->ubicacion; ?></td>
                                <td data-titulo="Nombre"><?php echo $stock->producto->nombre?></td> <!--  Nombre  -->
                                <td data-titulo="Presentación"><?php echo $stock->producto->presentacion;?></td> <!--  Presentación  -->
                                <td data-titulo="Cantidad"><?php echo $stock->cantidad; ?></td> <!--  Cantidad  -->
                                <td data-titulo="Movimiento"><?php echo $stock->movimiento; ?></td> <!--  Nombre Movimiento  -->
                                <td data-titulo="Creador"><?php echo $stock->usuario->nombre . " " . $stock->usuario->apellido  ; ?></td> <!--  Creador  -->
                                <td data-titulo="Creado"><?php echo $fechaCreacionFormateada; ?></td> <!-- Fecha Creación   -->
                            </tr>
                        <?php endif ?>
                    <?php endforeach; ?>
                <?php } ?>
            <tbody>
        </table>
    </form>     
  </section>   