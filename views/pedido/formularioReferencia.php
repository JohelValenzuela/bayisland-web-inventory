
<div style="width: inherit;">
<table class="tabla" id="">
<h2 style="color: black; margin-bottom: 5rem;">Detalle de productos por pedido</h2>
    <thead>
        <tr>
            <th></th>    
            <th>ID</th>
            <th>Referencia</th>
            <th>Estado</th>
            <th>Creado Por</th>
            <th>Desicion Por</th>
            <th>Fecha de Creación</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($maestro)) { ?>

                <?php
                    $action = isset($_GET['action']) ? $_GET['action'] : ''; // Variable para almacenar la acción actual
                    $idMaestro = isset($_GET['id']) ? $_GET['id'] : ''; // ID del maestro actual

                    // Verificar si la acción es "ver_mas" o "ocultar" para el maestro específico
                    $isVerMas = ($action == 'ver_mas' && intval($idMaestro) == $maestro->id);
                    $isOcultar = ($action == 'ocultar' && $idMaestro == $maestro->id);

                    // Convertir la fecha de creación al formato dd-mm-yyyy
                    $fechaCreacion = new DateTime($maestro->fechaCreacion);
                    $fechaCreacionFormateada = $fechaCreacion->format('d-m-Y H:i:s');
                ?>

                <tr>
                    <td>
                        <div class="acciones-tabla">
                            <?php if(!$isVerMas) : ?> <!-- Mostrar el botón "Ver Más" solo si no se está mostrando la tabla -->
                                <a class="boton-accion entrada" href="?id=<?php echo $maestro->id; ?>&action=ver_mas">
                                    <i class="fa-regular fa-eye accion toggle-on"></i>
                                </a>
                            <?php endif ?>              
                            <?php if($isVerMas) : ?> <!-- Mostrar el botón "Ocultar" solo si se está mostrando la tabla -->
                                <a class="boton-accion salida" href="?id=<?php echo $maestro->id; ?>&action=ocultar">
                                    <i class="fa-regular fa-eye-slash accion toggle-off"></i>
                                </a>  
                            <?php endif ?>
                        </div>
                    </td>

                    <td data-titulo="Id"><?php echo $maestro->id; ?></td>
                    <td data-titulo="Referencia"><?php echo $maestro->referencia; ?></td>
                    <td data-titulo="Estado">
                        <?php if($maestro->estado === 'Aceptado') : ?>
                            <a class="estado aceptado"> Aceptado </a>
                        <?php elseif($maestro->estado === 'Rechazado'): ?>
                            <a class="estado rechazado"> Rechazado </a>
                        <?php else: ?>
                            <a class="estado pendiente"> Pendiente </a>
                        <?php endif ?>              
                    </td>
                    <td data-titulo="Creador"><?php echo $maestro->usuario->nombre . " " . $maestro->usuario->apellido; ?></td>
                    <?php if ($maestro->usuarioIdAprueba == 0) : ?>
                        <td data-titulo="Aprobado"><?php echo 'Sin Aprobación'; ?></td>
                    <?php else : ?>
                        <td data-titulo="Aprobado"><?php echo $maestro->usuarioAprueba->nombre . " " . $maestro->usuarioAprueba->apellido; ?></td>
                    <?php endif ?>
                    <td data-titulo="Creado"><?php echo $fechaCreacionFormateada; ?></td>
                </tr>
                <?php if(isset($_GET['action']) && $_GET['action'] == 'ver_mas' && isset($_GET['id']) && $_GET['id'] == $maestro->id) : ?>
                    <tr>
                        <td colspan="8"> <!-- colspan 8 para cubrir todas las columnas -->
                            <table class="tabla" id="">
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
                                                                    <input type="hidden" name="id" value="">
                                                                    <button disabled type="submit" value="" class="boton-accion eliminar"> 
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
            <!-- < ?php endforeach; ?> -->
        <?php } ?> 
    </tbody>
</table>   
</div>


<input name="referencia" id="referencia" type="hidden" value="<?php echo s($maestro->referencia) ?>"/>

<div class="div-flex" >
    <div class="campo campo-separado w-30 ">
        <label for="cantidad" >Cantidad de productos en detalle:</label>
        <input class="estado deshabilitado" disabled name="cantidad" id="cantidad" type="text" value="<?php echo s($cuentaDetalle) ?>"/>
    </div>

    <div class="campo campo-separado w-30">
        <label for="cantidad2">Cantidad de productos del pedido:</label>
        <input class="estado deshabilitado" disabled  name="cantidad2" id="cantidad2" type="text" value="<?php echo s(0) ?>"/>
    </div>

    <div class="campo campo-separado w-40">
        <label for="estado" >Estado</label>
        <select name="estado" id="">
            <option selected value>-- Seleccione --</option>
            <option value="<?php echo s($maestro->estado = 'Aceptado') ?>">Aceptar</option>
            <option value="<?php echo s($maestro->estado = 'Rechazado') ?>" >Rechazar</option>               
        </select>
    </div>
</div>








    




















<!-- <div class="campo campo-separado">
    <label for="categoria">Categoria</label>             
    <select disabled name="categoriaId" id="categoria">           
        <option selected value>-- Seleccione --</option>               
        < ?php foreach($categoria as $categoria):  ?>
            <option < ?php echo $pedido->categoriaId === $categoria->id ? 'selected' : '' ?> value="< ?php echo s($categoria->id); ?>" >< ?php echo s($categoria->nombre); ?> </option>
        < ?php endforeach; ?>                
    </select>
</div>

<div class="campo campo-separado">
    <label for="producto">Producto del Pedido</label>             
    <select disabled name="productoId" id="producto">           
        <option selected value>-- Seleccione --</option>               
        < ?php foreach($producto as $producto):  ?>
            <option < ?php echo $pedido->productoId === $producto->id ? 'selected' : '' ?> value="< ?php echo s($producto->id); ?>" >< ?php echo s($producto->nombre . " | " . $producto->presentacion . " | " . $producto->unidad_empaque . " | " . $producto->cantidad . " unidades | "); ?> </option>
        < ?php endforeach; ?>                
    </select>
</div> -->
