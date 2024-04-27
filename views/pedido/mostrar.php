<section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      <span class="text">Pedido</span>
    </div>
        
    <section class="form form-contenido form-flex form-botones form-buscar">
        <div class="form-flex">
            <a class="boton-exportar agregar" href="/pedido/crear">  <i class="fa-regular fa-square-plus"></i> Crear Pedido</a>
            <a class="boton-exportar pdf" href="/fpdf/pdfPedido" target="_blank"> <i class="fa-solid fa-file-pdf"></i> PDF</a> 
            
            
            <button id="btnExportar" class="boton-exportar">
              <i class="fa-solid fa-file-excel"></i> EXCEL
            </button>

            <a class="boton-exportar print" href="" target="_blank"> <i class="fa-solid fa-print"></i> Imprimir</a>   
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

    <form class="form form-contenido form-botones">
        <div class="campo select-buscar">
            <select class="buscar boton-exportar w-20" id="categoriaId" name="categoriaId" style="width: 100%;">
            
                <option disabled selected value>-- Filtrar Categoría --</option>
                <option value="">Mostrar Todos</option>
                
                <?php foreach($categoria as $categoria):  ?>
                    <option value="<?php echo s($categoria->nombre); ?>" ><?php echo s($categoria->nombre); ?> </option>
                <?php endforeach; ?>
                
            </select>
        </div>
        <div class="campo select-buscar">
            <select class="buscar" name="estado" id="estado" style="width: 100%;">
                <option disabled selected value>-- Filtrar Estado --</option>
                <option value="">Mostrar Todos</option>
                <option value="Aceptado">Aceptado</option>
                <option value="Rechazado" >Rechazado</option>     
                <option value="Pendiente" >Pendiente</option>            
            </select>

        </div>
    </form>

    <?php 
      include_once __DIR__ . "/../templates/alertas.php";
    ?>

    <form action="" class="form form-contenido form-tabla" method="POST" enctype="multipart/form-data">
      
        <table class="tabla" id="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Referencia</th>
                    <th>Categoria</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Observacion</th>
                    <th>Estado</th>
                    <th>Creado Por</th>
                    <th>Fecha de Creación</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>

            <tbody>
                <?php if(!empty($pedido)) { ?>
                    <?php foreach($pedido as $pedidos) : ?>
                    <tr>
                        <td data-titulo="Id"><?php echo $pedidos->id; ?></td>
                        <td data-titulo="Referencia"><?php echo $pedidos->referencia; ?></td>
                        <td data-titulo="Nombre"><?php echo $pedidos->categoria->nombre; ?></td>
                        <td data-titulo="Producto"><?php echo $pedidos->producto->nombre; ?></td>
                        <td data-titulo="Cantidad"><?php echo $pedidos->cantidad; ?></td>
                        <td data-titulo="Detalle" data-detalle="Detalle"><?php echo $pedidos->observacion; ?></td>
                        <td data-titulo="Estado">
                            <?php if($pedidos->estado === 'Aceptado') : ?>
                                <a class="estado aceptado"> Aceptado </a>
                            <?php elseif($pedidos->estado === 'Rechazado'): ?>
                                <a class="estado rechazado"> Rechazado </a>
                            <?php else: ?>
                                <a class="estado pendiente"> Pendiente </a>
                            <?php endif ?>              
                        </td>
                        <td data-titulo="Creador"><?php echo $pedidos->usuario->nombre . " " . $pedidos->usuario->apellido  ; ?></td>
                        <td data-titulo="Creado"><?php echo $pedidos->fechaCreacion; ?></td>

                        <td>
                            <div class="acciones-tabla">
                            <a class="boton-accion editar" href="/pedido/actualizar?id=<?php echo $pedidos->id; ?>">
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
                    <?php endforeach; ?>
                <?php } ?> 
            <tbody>
        </table>
    </form>   
  </section>   