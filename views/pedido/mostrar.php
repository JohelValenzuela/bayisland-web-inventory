<section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      <span class="text">Pedido</span>
    </div>
        
    <section class="form form-contenido form-flex form-botones form-buscar">
        <div class="form-flex">
            <a class="boton-exportar agregar" href="/pedido/crear">  <i class="fa-regular fa-square-plus"></i> Crear Pedido</a>
            <a class="boton-exportar pdf" href="/fpdf/pdfPedido" target="_blank"> <i class="fa-solid fa-file-pdf"></i> PDF</a> 
            
            
            <button id="btnExportarTabla" class="boton-exportar">
              <i class="fa-solid fa-file-excel"></i> EXCEL Pedidos
            </button>

          </div>

          <div>
            <form class="no-margin" action="/pedido/gestionaReferencia" method="POST"> 
                <div class="acciones-tabla form-flex">
                    <input class="input-carrito input-buscar" name="referencia" type="text" id="referencia" value="" placeholder="Buscar por Referencia" > </input>
                    <button type="submit" value="" class="boton-exportar eliminar"> 
                      <i class='bx bx-search-alt' ></i> Buscar
                    </button>
                </div>
            </form> 
          </div> 
    </section>

    <!-- <form class="form form-contenido form-botones">

        <div class="campo select-buscar w-40">
            <select class="buscar" name="estado" id="estado" style="width: 100%;">
                <option disabled selected value>-- Filtrar Estado --</option>
                <option value="">Mostrar Todos</option>
                <option value="Aceptado">Aceptado</option>
                <option value="Rechazado" >Rechazado</option>     
                <option value="Pendiente" >Pendiente</option>            
            </select>

        </div>
    </form> -->

    <?php 
      include_once __DIR__ . "/../templates/alertas.php";
    ?>

    <section action="" class="form form-contenido form-tabla" method="POST" enctype="multipart/form-data">

        <table class="tabla" id="tabla">
    <thead>
        <tr>   
            <th>ID</th>
            <th>Bodega</th>
            <th>Referencia</th>
            <th>Creado Por</th>
            <th>Desicion Por</th>
            <th>Estado</th>
            <th>Fecha de Creación</th>
            <th></th>
            <!-- <th>Editar</th>
            <th>Referencia</th>
            <th>Eliminar</th> -->
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($maestro)) { ?>
            <?php foreach($maestro as $maestros) : ?>
                <?php if($maestros->cantidadProductos > 0) : ?> <!-- Mostrar solo si la cantidad de productos es mayor que 0 -->

                    <?php
                        $idMaestro = $maestros->id;
                        $refereciaMaestro = trim($maestros->referencia);
                        $detalleMaestro = isset($detalle[$idMaestro]) ? $detalle[$idMaestro] : null;

                        // Convertir la fecha de creación al formato dd-mm-yyyy
                        $fechaCreacion = new DateTime($maestros->fechaCreacion);
                        $fechaCreacionFormateada = $fechaCreacion->format('d-m-Y H:i:s');
                    ?>

                
                    <?php

                        $action = isset($_GET['action']) ? $_GET['action'] : ''; // Variable para almacenar la acción actual
                        $idMaestro = isset($_GET['id']) ? $_GET['id'] : ''; // ID del maestro actual

                        // Verificar si la acción es "ver_mas" o "ocultar" para el maestro específico
                        $isVerMas = ($action == 'ver_mas' && $idMaestro == $maestros->id);
                        $isOcultar = ($action == 'ocultar' && $idMaestro == $maestros->id);  
                    ?>

                    <tr>
                        <!-- <td>
                            <div class="acciones-tabla">
                                < ?php if(!$isVerMas) : ?>
                                    <a class="boton-accion entrada" href="?id=< ?php echo $maestros->id; ?>&action=ver_mas">
                                        <i class="fa-regular fa-eye accion toggle-on"></i>
                                    </a>
                                < ?php endif ?>              
                                < ?php if($isVerMas) : ?>
                                    <a class="boton-accion salida" href="?id=< ?php echo $maestros->id; ?>&action=ocultar">
                                        <i class="fa-regular fa-eye-slash accion toggle-off"></i>
                                    </a>  
                                < ?php endif ?>
                            </div>
                        </td> -->

                        <td data-titulo="Id"><?php echo $maestros->id; ?></td>
                        <td data-titulo="Bodega"><?php echo $maestros->bodega->nombre . ' - ' . $maestros->bodega->ubicacion; ?></td> 
                        <td data-titulo="Referencia"><?php echo $maestros->referencia; ?></td>
                        <td data-titulo="Creador"><?php echo $maestros->usuario->nombre . " " . $maestros->usuario->apellido; ?></td>
                        <?php if ($maestros->usuarioIdAprueba == 0) : ?>
                            <td data-titulo="Aprobado"><?php echo 'Sin Aprobación'; ?></td>
                        <?php else : ?>
                            <td data-titulo="Aprobado"><?php echo $maestros->usuarioAprueba->nombre . " " . $maestros->usuarioAprueba->apellido; ?></td>
                        <?php endif ?>
                        <td data-titulo="Estado">
                            <?php if($maestros->estado === 'Aceptado') : ?>
                                <a class="estado aceptado"> Aceptado </a>
                            <?php elseif($maestros->estado === 'Rechazado'): ?>
                                <a class="estado rechazado"> Rechazado </a>
                            <?php elseif($maestros->estado === 'Recibido'): ?>
                                <a class="estado recibido"> Recibido </a>
                            <?php else: ?>
                                <a class="estado pendiente"> Pendiente </a>
                            <?php endif ?>              
                        </td>
                        <td data-titulo="Creado"><?php echo $fechaCreacionFormateada; ?></td>
                        <td>
                            <div class="acciones-tabla">
                                <a class="boton-accion entrada" href="/pedido/gestionaReferencia?id=<?php echo $maestros->id;?>">
                                    <i class="fa-regular fa-pen-to-square accion"></i>
                                </a>
                                <?php if($maestros->estado === 'Aceptado') : ?>
                                    <a id="btnRecibirPedido" class="boton-accion agrega" href="/stock/recibir?id=<?php echo $maestros->id; ?>&bodegaId=<?php echo $maestros->bodegaId; ?>">
                                        <i class="fa-solid fa-boxes accion"></i> Recibir Pedido
                                    </a>
                                    <?php elseif($maestros->estado === 'Recibido' || $maestros->estado === 'Pendiente' || $maestros->estado === 'Rechazado'): ?>
                                    <a id="btnRecibirPedido" class="boton-accion estado deshabilitado no-borde">
                                        <i class="fa-solid fa-boxes accion"></i> Recibir Pedido
                                    </a>
                                <?php endif ?>                  
                            </div>
                        </td>
                    </tr>
                    <?php if(isset($_GET['action']) && $_GET['action'] == 'ver_mas' && isset($_GET['id']) && $_GET['id'] == $maestros->id) : ?>
                        <?php
                            // Crear un array para almacenar los datos de la tabla2
                            $datosTabla2 = [];
                        ?>
                        <tr>
                            <td colspan="8"> <!-- colspan 8 para cubrir todas las columnas -->
                                <table class="tabla" id="tabla2">
                                    <thead>
                                        <tr>  
                                            <th>ID</th>
                                            <th>ID Maestro</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Observacion</th>
                                            <th>Editar Pedido</th>
                                            <th>Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($detalle)) { ?>
                                            <?php foreach($detalle as $detalles) : ?>
                                                <?php
                                                        // Iterar sobre los datos de la tabla2 y agregar cada fila al array
                                                        // Crear un array asociativo para representar cada fila de la tabla2
                                                        $filaTabla2 = array(
                                                            "ID" => $detalles->id,
                                                            "maestroId" => $detalles->maestroId,
                                                            "productoId" => $detalles->productoId,
                                                            "cantidad" => $detalles->cantidad,
                                                            "observacion" => $detalles->observacion
                                                        );
                                                            // Agregar la fila al array de datos de la tabla2
                                                            $datosTabla2[] = $filaTabla2;
                                                    ?> 
                                                <?php $idDetalle = $detalles->maestroId; ?>
                                                <?php if($idMaestro == $idDetalle) : ?>
                                                    <tr>
                                                        <td data-titulo="Id"><?php echo $detalles->id; ?></td>
                                                        <td data-titulo="Maestro"><?php echo $detalles->maestroId; ?></td>
                                                        <td data-titulo="Producto"><?php echo $detalles->producto->nombre; ?></td>
                                                        <td data-titulo="Cantidad"><?php echo $detalles->cantidad; ?></td>
                                                        <td data-titulo="Observacion"><?php echo $detalles->observacion; ?></td>
                                                        <td>
                                                            <div class="acciones-tabla">
                                                                <a class="boton-accion entrada" href="/pedido/actualizar?id=<?php echo $detalles->id; ?>">
                                                                    <i class="fa-regular fa-pen-to-square accion"></i>    
                                                                </a>                  
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="acciones-tabla">
                                                                <a class="boton-accion">
                                                                    <form class="no-margin" action="/pedido/eliminar" method="POST"> 
                                                                        <input type="hidden" name="id" value="<?php echo $detalles->id; ?>">
                                                                        <button type="submit" value="" class="boton-accion eliminar"> 
                                                                            <i class="fa-regular fa-trash-can accion"></i> 
                                                                        </button>
                                                                    </form>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endif ?>
                                            <?php endforeach; ?>
                                        <?php } ?> 
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <!-- <tr>
                            <td colspan="7">
                                <div class="acciones-tabla">
                                </div>
                            </td>
                        </tr> -->
                    <?php endif; ?>
                <?php endif ?>
            <?php endforeach; ?>
            
        <?php } ?> 
    </tbody>
</table>     

    </section>   
</section>   

