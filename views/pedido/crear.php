<section class="home-section">
    
    <?php include __DIR__ . '/navcarrito.php' ?>
    
    <section action="" class="form form-contenido form-tabla" method="POST" enctype="multipart/form-data">
      
        <table class="tabla table_id" id="tabla">
        <?php if(!empty($producto)) { ?>
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Categoría</th>
                    <th>Producto</th>
                    <th>Presentación</th>
                    <th>Cant Presentación</th>
                    <th>Medida</th>
                    <th>Tipo Empaque</th>
                    <th>Cant. por Empaque</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach($producto as $productos) : ?>
                <tr>
                    <td>
                        <form class="no-margin" action="/pedido/carrito" method="POST"> 
                            <div class="acciones-tabla">
                                <input name="id" type="hidden" id="id" value="<?php echo $productos->id; ?>"> </input>
                                <input name="categoriaId" type="hidden" id="categoriaId" value="<?php echo $productos->categoriaId;?>"> </input>
                                <input name="cantidad" type="hidden" id="cantidad" value="<?php echo $productos->cantidad;?>"></input>
                                <input name="nombre" type="hidden" id="nombre" value="<?php echo $productos->nombre; ?>"> </input>
                                <input name="presentacion" type="hidden" id="presentacion" value="<?php echo $productos->presentacion; ?>"> </input>
                                <input name="cantidadPresentacion" type="hidden" id="cantidadPresentacion" value="<?php echo $productos->cantidadPresentacion; ?>"> </input>
                                <input name="medidaId" type="hidden" id="medidaId" value="<?php echo $productos->medidaId; ?>"> </input>
                                <input name="unidad_empaque" type="hidden" id="unidad_empaque" value="<?php echo $productos->unidad_empaque; ?>"> </input>


                                <button type="submit" value="" class="boton-accion eliminar"> 
                                    <i class="fa-regular fa-square-plus agrega"> </i>
                                </button>
                            </div>
                        </form>
                    </td>
                    <td data-titulo="ID"><?php echo $productos->id;?></td>
                    <td data-titulo="Categoría"><?php echo $productos->categoria->nombre;?></td>
                    <td data-titulo="Producto"><?php echo $productos->nombre; ?></td>
                    <td data-titulo="Presentación"><?php echo $productos->presentacion; ?></td>
                    <td data-titulo="Cant.Presentación"><?php echo $productos->cantidadPresentacion; ?></td>
                    <td data-titulo="Medida"><?php echo $productos->medida->nombre; ?></td>
                    <td data-titulo="Empaque"><?php echo $productos->unidad_empaque; ?></td>
                    <td data-titulo="Cantidad"><?php echo $productos->cantidad; ?></td>
                </tr>
            <?php endforeach; ?>
            <tbody>
      </table>
    </section> 

    <?php } else { ?>
      <p class="alerta info">NO HAY PEDIDOS</p>
    <?php } ?>

</section>  
