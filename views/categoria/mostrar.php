<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Categoría</span>
    </div>
    
    <form class="form form-contenido form-botones">
        <a class="boton-exportar agregar" href="/categoria/crear"> <i class="fa-regular fa-square-plus"></i> Agregar</a>
        <a class="boton-exportar pdf" href="/fpdf/pdfCategoria" target="_blank"> <i class="fa-solid fa-file-pdf"></i> PDF</a>   
        

        <button id="btnExportar" class="boton-exportar">
            <i class="fa-solid fa-file-excel"></i> EXCEL
        </button>

        <a class="boton-exportar print" href="" target="_blank"> <i class="fa-solid fa-print"></i> Imprimir</a>   

    </form>

    <form action="/categoria/crear" class="form form-contenido form-tabla" method="POST" enctype="multipart/form-data">
        <table class="tabla" id="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Categoría</th>
                    <th>Estado</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($categoria)) { ?>
                    <?php foreach($categoria as $categoria) : ?>
                        <?php if($categoria->estado === 'Inactivo'){
                                $clase = 'estado deshabilitado';
                            } else {
                                $clase = '';
                            } ?>

                        <tr  class="<?php echo $clase ?>">
                            <td data-titulo="Id"><?php echo $categoria->id; ?></td>
                            <td data-titulo="Nombre"><?php echo $categoria->nombre; ?></td>
                            <td data-titulo="Estado">
                                <?php if($categoria->estado === 'Activo') : ?>
                                    <a class="estado activo"> Activo </a>
                                <?php else: ?>
                                        <a> Inactivo </a>
                                <?php endif ?>               
                            </td>
                            <td>
                                <div class="acciones-tabla">
                                    <a class="boton-accion editar" href="/categoria/actualizar?id=<?php echo $categoria->id; ?>">
                                        <i class="fa-regular fa-pen-to-square accion"></i>                      
                                    </a>                 
                                </div>
                            </td>
                            <td>
                                <div class="acciones-tabla">
                                    <a class="boton-accion">
                                        <form class="no-margin" action="/categoria/desactivar" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $categoria->id; ?>">                      
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