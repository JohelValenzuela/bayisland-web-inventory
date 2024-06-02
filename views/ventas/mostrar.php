<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Control de Ventas</span>
    </div>
        
    <form class="form form-contenido form-botones">
        <a class="boton-exportar" href="/ventas/carrito"> <i class="fa-regular fa-square-plus"></i> Crear Venta</a>
        <a class="boton-exportar" href="/ventas/carrito"> <i class="fa-regular fa-square-plus"></i> Cobrar a Cliente</a>
        <a class="boton-exportar pdf" href="/fpdf/pdfStock" target="_blank"> <i class="fa-solid fa-file-pdf"></i> PDF </a>  
        <button id="btnExportar" class="boton-exportar"> 
            <i class="fa-solid fa-file-excel"></i> EXCEL
        </button>
        <a class="boton-exportar print" href="" target="_blank"> <i class="fa-solid fa-print"></i> Imprimir</a>   
    </form>

    <form class="form form-contenido form-botones">
        <div class="campo select-buscar">
        <select class="buscar" id="cliente_id" name="cliente" style="width: 100%;">
                <option value="">Seleccione un cliente</option>
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo $cliente->id; ?>"><?php echo $cliente->nombre; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <form action="" class="form form-contenido form-tabla" method="POST" enctype="multipart/form-data"> 
        <table class="tabla" id="">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Código Brazalete</th>
                    <th>Fecha Venta</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($venta)) { ?>
                    <?php foreach($venta as $ventas) : ?> 
                        <?php     
                            $isVerMas = isset($_GET['id']) && $_GET['id'] == $ventas->id && isset($_GET['action']) && $_GET['action'] == 'ver_mas'; 
                            
                            // Convertir la fecha de creación al formato dd-mm-yyyy
                            $fechaCreacion = new DateTime($ventas->fecha);
                            $fechaCreacionFormateada = $fechaCreacion->format('d-m-Y H:i:s');
                        ?>
                        <tr>
                            <td>
                                <div class="acciones-tabla">
                                    <?php if(!$isVerMas) : ?> <!-- Mostrar el botón "Ver Más" solo si no se está mostrando la tabla -->
                                        <a class="boton-accion entrada" href="?id=<?php echo $ventas->id; ?>&action=<?php echo $isVerMas ? 'ocultar' : 'ver_mas'; ?>">
                                            <i class="fa-regular fa-eye accion toggle-on"></i>
                                        </a>
                                    <?php else: ?> <!-- Si se está mostrando la tabla, mostrar el botón "Ocultar" -->
                                        <a class="boton-accion entrada" href="?id=<?php echo $ventas->id; ?>&action=<?php echo $isVerMas ? 'ocultar' : 'ver_mas'; ?>">
                                            <i class="fa-regular fa-eye-slash accion toggle-off"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td data-titulo="Id"><?php echo $ventas->id; ?></td>
                            <td data-titulo="Nombre"><?php echo $ventas->cliente->nombre;?></td>
                            <td data-titulo="Brazalete"><?php echo $ventas->cliente->codigo_brazalete;?></td>
                            <td data-titulo="Fecha"><?php echo $fechaCreacionFormateada; ?></td>
                        </tr>
                        <?php if($isVerMas) : ?>
                            <tr>
                                <td colspan="7">
                                    <table class="tabla" id="tabla2">
                                        <thead>
                                            <tr>  
                                                <th>ID</th>
                                                <th>Venta</th>
                                                <th>Producto</th>
                                                <!-- <th>Receta</th> -->
                                                <th>Cantidad</th>
                                                <th>Precio</th>
                                                <th>Método Pago</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $ventaProductoEncontrado = false;
                                                foreach($ventaProducto as $ventaProductos) : 
                                                    if($ventaProductos->venta_id == $ventas->id) {
                                                        $ventaProductoEncontrado = true;
                                            ?>
                                            <tr>
                                                <td data-titulo="Id"><?php echo $ventaProductos->id; ?></td>
                                                <td data-titulo="Venta"><?php echo $ventaProductos->venta_id; ?></td>
                                                <td data-titulo="Producto o Receta">
                                                    <?php if ($ventaProductos->producto_id !== 0 && $ventaProductos->producto) {
                                                        echo $ventaProductos->producto->nombre;
                                                    } elseif ($ventaProductos->receta_id !== 0 && $ventaProductos->receta) {
                                                        echo $ventaProductos->receta->nombre;
                                                    } else {
                                                        echo 'Nada';
                                                    } ?>
                                                </td>
                                                <td data-titulo="Cantidad"><?php echo $ventaProductos->cantidad; ?></td>
                                                <td data-titulo="Precio"><?php echo $ventaProductos->precio; ?></td>
                                                <td data-titulo="Método Pago"><?php echo $ventaProductos->metodoPago; ?></td>
                                            </tr>
                                            <?php 
                                                    }
                                                endforeach; 
                                                if (!$ventaProductoEncontrado) {
                                            ?>
                                                    <tr>
                                                        <td colspan="8" class="sin-registro">
                                                            <a class="sin-registro">Esta venta no posee productos</a>
                                                        </td>
                                                    </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php } ?> 
            </tbody>
        </table>
    </form>
</section>
