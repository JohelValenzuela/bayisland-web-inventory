<section class="home-section">
    <div class="flex-carrito">
        <div class="home-content">
            <i class='bx bx-menu' ></i>
            <span class="text"> Retirar Stock</span>
        </div>
        <div class="home-carrito">
            <a href="/stock" class="boton-exportar volver"> Regresar  <i class="fa-solid fa-person-walking-arrow-loop-left"></i> </a>
        </div>
    </div>

    <?php 
      include_once __DIR__ . "/../templates/alertas.php";
    ?>

    <form action="" class="form form-contenido contenedor-flex" method="POST" value="Crear" enctype="multipart/form-data">
        
        <div class="campo campo-separado campo-flex">
            <label for="producto">Producto del Pedido</label>  
                    
            <select class="buscar" name="productoId" id="producto">
                    
                <option disabled selected value>-- Seleccione --</option>
                        
                <?php foreach($producto as $producto):  ?>
                    <option  <?php echo $stock->productoId === $producto->id ? 'selected' : '' ?> value="<?php echo s($producto->id); ?>" ><?php echo s($producto->nombre . " | " . $producto->presentacion . " | " . $producto->unidad_empaque . " | " . $producto->cantidad  . " unidades | "); ?> </option>
                <?php endforeach; ?>
                        
            </select>
        </div>

        <div class="campo campo-separado campo-flex">
            <label for="cantidad" >Cantidad</label>
            <input name="cantidad" id="cantidad" type="text" placeholder="Cantidad"  value="<?php echo s($stock->cantidad) ?>"/>
        </div>

        <div class="campo campo-separado">
            <input type="submit" value="Retirar Stock" class="boton boton-azul">
        </div>

    </form> 

</section>   