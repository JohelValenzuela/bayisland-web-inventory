<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Producto</span>
    </div>

    <form class="form form-contenido form-botones">
        <a class="boton-exportar" href="producto/crear"> <i class="fa-regular fa-square-plus"></i> Agregar</a>
        <a class="boton-exportar pdf" href="/fpdf/pdfProducto" target="_blank"> <i class="fa-solid fa-file-pdf"></i> PDF</a>  


        <button id="btnExportar" class="boton-exportar">
            <i class="fa-solid fa-file-excel"></i> EXCEL
        </button>

        <a class="boton-exportar print" href="" target="_blank"> <i class="fa-solid fa-print"></i> Imprimir</a>   

    </form>

    <form class="form form-contenido form-botones">
        <div class="campo select-buscar">
            <select class="buscar boton-exportar" id="categoriaId" name="categoriaId" style="width: 100%;">
            
                <option disabled selected value>-- Filtrar Categoría --</option>
                <option value="">Mostrar Todos</option>
                
                <?php foreach($categoria as $categoria):  ?>
                    <option value="<?php echo s($categoria->nombre); ?>" ><?php echo s($categoria->nombre); ?> </option>
                <?php endforeach; ?>
                
            </select>
        </div>
        <div class="campo select-buscar">
            <select class="buscar" name="medidaId" id="medidas" style="width: 100%;">              
                <option disabled selected value>-- Filtrar Medida --</option>
                <option value="">Mostrar Todos</option>          
              <?php foreach($medidas as $medida):  ?>
                <option value="<?php echo s($medida->nombre); ?>" ><?php echo s($medida->nombre); ?> </option>
              <?php endforeach; ?>            
            </select>
        </div>
        <div class="campo select-buscar">
            <select class="buscar" name="estado" id="estado" style="width: 100%;">
                <option disabled selected value>-- Filtrar Estado --</option>
                <option value="">Mostrar Todos</option>
                <option value="Activado">Activo</option>
                <option value="Inactivo">Inactivo</option>               
            </select>

        </div>
    </form>


    <form action="/auth/crear_cuenta" class="form form-contenido form-tabla" enctype="multipart/form-data">
        <table class="tabla table_id" id="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Categoría</th>
                    <th>Producto</th>
                    <th>Presentación</th>
                    <th>Cant Presentación</th>
                    <th>Medida</th>
                    <th>Tipo Empaque</th>
                    <th>Cant. por Empaque</th>
                    <th>Total Medida</th>
                    <th>Precio Producto</th>
                    <th>Precio por Medida</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($producto) OR isset($_GET['buscar'])) { ?>
                <?php foreach($producto as $productos) : ?>
                    <?php if($productos->estado === 'Inactivo'){
                        $clase = 'estado deshabilitado';
                    } else {
                        $clase = '';
                    } ?>
                    <tr class="<?php echo $clase ?>">
                            <td data-titulo="Id"><?php echo $productos->id; ?></td>
                            <td data-titulo="Categoría"><?php echo $productos->categoria->nombre;?></td>
                            <td data-titulo="Producto"><?php echo $productos->nombre; ?></td>
                            <td data-titulo="Presentación"><?php echo $productos->presentacion; ?></td>
                            <td data-titulo="Id"><?php echo $productos->cantidadPresentacion; ?></td>
                            <td data-titulo="Medida"><?php echo $productos->medida->nombre; ?></td>
                            <td data-titulo="Empaque"><?php echo $productos->unidad_empaque; ?></td>
                            <td data-titulo="Cantidad"><?php echo $productos->cantidad; ?></td>
                            <td data-titulo="Cantidad Medida"><?php echo $productos->totalMedida; ?></td>
                            <td data-titulo="Precio Producto"><?php echo $productos->precioUnidad; ?></td>
                            <td data-titulo="Precio Medida"><?php echo $productos->precioMedida; ?></td>
                            <td data-titulo="Total"><?php echo $productos->total; ?></td>
                            <td data-titulo="Estado">
                            <?php if($productos->estado === 'Activo') : ?>
                                <a class="estado activo"> Activado </a>
                                <?php else: ?>
                                <a> Inactivo </a>
                            <?php endif ?>              
                            </td>
                            <td>
                            <div class="acciones-tabla">
                                <a class="boton-accion editar" href="/producto/actualizar?id=<?php echo $productos->id; ?>">
                                    <i class="fa-regular fa-pen-to-square accion"></i>  
                                </a>                    
                            </div>
                            </td>
                            <td>
                            <div class="acciones-tabla">
                                <a class="boton-accion">
                                    <form class="no-margin" action="/producto/eliminar" method="POST"> 
                                        <input type="hidden" name="id" value="<?php echo $productos->id; ?>">
                                        <button type="submit" value="" class="boton-accion eliminar"> 
                                            <i class="fa-regular fa-trash-can accion"></i> 
                                        </button>
                                    </form>
                                </a>
                                
                            </div>
                            </td>
                        </tr>

                <?php endforeach; ?>
            <?php } ?>
            <tbody>
        </table>
    </form> 
</section>   


