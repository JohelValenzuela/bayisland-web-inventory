<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Unidad de Medida</span>
    </div>
        
    <form class="form form-contenido form-botones">
        <a class="boton-exportar agregar" href="/medida/crear"> <i class="fa-regular fa-square-plus"></i> Agregar</a>
        <a class="boton-exportar pdf" href="/fpdf/pdfMedidas" target="_blank"> <i class="fa-solid fa-file-pdf"></i> PDF</a>  

        
        <button id="btnExportar" class="boton-exportar">
            <i class="fa-solid fa-file-excel"></i> EXCEL
        </button>
  
    </form>

    <form class="form form-contenido form-botones">
        <div class="campo select-buscar">
            <select class="buscar" name="estado" id="estado" style="width: 100%;">
                <option disabled selected value>-- Filtrar Estado --</option>
                <option value="">Mostrar Todos</option>
                <option value="Activado">Activo</option>
                <option value="Inactivo " >Inactivo</option>               
            </select>

        </div>
    </form>

    <form action="/pedido/crear" class="form form-contenido form-tabla" method="POST" enctype="multipart/form-data">
      
        <table class="tabla" id="tabla">
            <?php if(!empty($medidas)) { ?>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Sigla</th>
                    <th>Estado</th>
                    <th>Editar</th>
                    <!-- <th>Eliminar</th> -->
                </tr>
            </thead>

            <tbody>
                <?php foreach($medidas as $medidas) : ?>
                    <?php if($medidas->estado === 'Inactivo'){
                    $clase = 'estado deshabilitado';
                } else {
                    $clase = '';
                } ?>

                <tr class="<?php echo $clase ?>">
                    <td data-titulo="Id"><?php echo $medidas->id; ?></td>
                    <td data-titulo="Nombre"><?php echo $medidas->nombre; ?></td>
                    <td data-titulo="Sigla"><?php echo $medidas->sigla; ?></td>
                    <td data-titulo="Estado">
                        <?php if($medidas->estado === 'Activo') : ?>
                            <a class="estado activo"> Activado </a>
                        <?php else: ?>
                            <a> Inactivo </a>
                        <?php endif ?>             
                    </td>
                    <td>
                        <div class="acciones-tabla">
                        <a class="boton-accion editar" href="/medida/actualizar?id=<?php echo $medidas->id; ?>">
                            <i class="fa-regular fa-pen-to-square accion"></i>     
                        </a>
                        </div>
                    </td>
                    <!-- <td>
                        <div class="acciones-tabla">
                            <a class="boton-accion">
                                <form class="no-margin" action="/medida/eliminar" method="POST"> 
                                <input type="hidden" name="id" value="">
                                <button type="submit" value="" class="boton-accion eliminar"> 
                                    <i class="fa-regular fa-trash-can accion"></i> 
                                </button>
                                </form>
                            </a>
                        </div>
                    </td> -->
                </tr>
                <?php endforeach; ?>
            <tbody>
        </table>
    </form>    
    
        <!-- < ?php
      echo $paginacion;
    ?> -->


       <?php } else { ?>
        <p class="alerta info">NO HAY UNIDADES DE MEDIDA</p>
    <?php } ?> 
    
  </section>   