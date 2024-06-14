<section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      <span class="text">Control de Usuario</span>
    </div>
    
    <form class="form form-contenido form-botones">
      <a class="boton-exportar agregar" href="/auth/crear_cuenta"> <i class="fa-regular fa-square-plus"></i> Agregar</a>
      <a class="boton-exportar pdf" href="/fpdf/pdfUsuario" target="_blank"> <i class="fa-solid fa-file-pdf"></i> PDF</a>  

      
      <button id="btnExportar" class="boton-exportar">
        <i class="fa-solid fa-file-excel"></i> EXCEL
      </button>

    </form>

    <form class="form form-contenido form-botones">
        <div class="campo select-buscar">
            <select class="buscar" id="productoId" name="producto" style="width: 100%;">
            
                <option disabled selected value>-- Filtrar Roles --</option>
                <option value="">Mostrar Todos</option>
                
                <?php foreach($roles as $rol):  ?>
                    <option value="<?php echo s($rol->tipoRol); ?>" ><?php echo s($rol->tipoRol); ?> </option>
                <?php endforeach; ?>
                
            </select>
        </div>
        <div class="campo select-buscar">
            <select class="buscar" name="estado" id="estado" style="width: 100%;">
                <option disabled selected value>-- Filtrar Estado --</option>
                <option value="">Mostrar Todos</option>
                <option value="Activado">Activo</option>
                <option value="Inactivo " >Inactivo</option>               
            </select>

        </div>
    </form>


    <section action="" class="form form-contenido form-tabla" method="POST" enctype="multipart/form-data">
    <?php if(!empty($usuarios)) { ?>  
      <table class="tabla" id="tabla">

        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acceso</th>
                <th>Estado</th>
                <th>Editar</th>
                <th></th>
            </tr>
        </thead>

      <tbody>
        <?php foreach($usuarios as $usuario) : ?>
            <?php if($usuario->estado === 'Inactivo'){
                    $clase = 'estado deshabilitado';
                } else {
                    $clase = '';
                } ?>
            <tr class="<?php echo $clase ?>">
                <td data-titulo="Id"><?php echo $usuario->id; ?></td>
                <td data-titulo="Nombre"><?php echo $usuario->nombre . " " . $usuario->apellido  ; ?></td>
                <td data-titulo="Correo"><?php echo $usuario->correo; ?></td>
                <td data-titulo="Rol"><?php echo $usuario->rol->tipoRol; ?></td>
                <td data-titulo="Confirmado">
                    <?php if($usuario->confirmado === '1') : ?>
                        <a class="estado check"><i class='bx bxs-check-shield' ></i></a>
                    <?php else: ?>
                        <a class="estado x"><i class='bx bxs-shield-x'></i></a>
                    <?php endif ?>              
                </td>
                <td data-titulo="Estado">
                    <?php if($usuario->estado === 'Activo') : ?>
                        <a class="estado activo"> Activado </a>
                        <?php else: ?>
                            <a class="estado inactivo"> Inactivo </a>
                        <?php endif ?>              
                </td>
                <td>
                    <div class="acciones-tabla">
                        <a class="boton-accion editar" href="/auth/actualizar_cuenta?id=<?php echo $usuario->id; ?>">
                            <i class="fa-regular fa-pen-to-square accion"></i>                                
                        </a>          
                    </div>
                </td>
                
                
               
                <td>
                    <div class="acciones-tabla">
                    <!-- < ?php if($usuario->rolId === '2') :?>     -->

                        <?php if($usuario->estado === 'Activo') :?>
                            <a class="boton-accion">
                                <form class="no-margin" action="/auth/desactivar" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">                      
                                    <button type="submit" value="" class="boton-accion eliminar"> 
                                        <i class="fa-solid fa-toggle-on toggle-on"></i>                              
                                    </button>
                                </form>
                            </a>                              
                        <?php elseif($usuario->estado === 'Inactivo') :?>
                            <a class="boton-accion">
                                <form class="no-margin" action="/auth/activar" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">                      
                                    <button type="submit" value="" class="boton-accion eliminar"> 
                                        <i class="fa-solid fa-toggle-off toggle-off"></i>                                
                                    </button>
                                </form>
                            </a>  
                        <?php endif ?>

                        
                    <!-- < ?php endif ?> -->
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
      <tbody>
            </table>



    </section> 
    


<?php } else { ?>
        <p class="alerta info">NO HAY USUARIOS</p>
    <?php } ?>
  </section>   