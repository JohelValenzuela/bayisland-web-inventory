<section class="home-section" style="height: auto; background: white;">
    <?php include __DIR__ . '/navcarrito.php' ?>
    <?php include_once __DIR__ . "/../templates/alertas.php";?>

    <section class="display-buscador">
    </section>

    <form class="form form-contenido form-botones">
        <div class="campo campo-separado buscador">
            <label for="inputBusqueda">Buscar productos:</label>
            <input type="text" id="inputBusqueda" class="campo-buscar" placeholder="Buscar productos...">
            <span id="btnClear" class="clear-button">&#10005;</span>
        </div>
        <div class="campo campo-separado">
            <label for="filtroCategoria">Filtrar por Categoría:</label>
            <select id="filtroCategoria" class="filtro-categoria">
                <option value="">Todas las categorías</option>
                <?php foreach($categoria as $categorias):  ?>
                    <option value="<?php echo s($categorias->id); ?>" ><?php echo s($categorias->nombre); ?> </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

        
    
    <div class="contenedor-flex">
        <!-- Contenedor de categorías -->
        <div class="contenedor-categoria">
            <h2>Categorías</h2>
            <ul class="contenedor-flex listado-categoria">
                <li style="flex: 1 1 100%;">
                    <a href="#" class="categoria-enlace mostrar-todos" data-categoria="">Mostrar Todos</a>
                </li>
                <?php foreach($categoria as $cat): ?>
                    <li style="flex: 1 1 50%;">
                        <a href="#" class="categoria-enlace" data-categoria="<?php echo $cat->id; ?>" style="">
                            <?php echo s($cat->nombre); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>


        <!-- Contenedor de productos -->
        <div class="productos-container">
        <h2>Lista de Productos</h2> <!-- Título de Productos -->
            <?php if(!empty($producto)) { ?>
                <?php foreach($producto as $productos) : ?>
                    <div class="producto-card w-30" data-categoria="<?php echo $productos->categoria->id; ?>">
                        <div class="producto-info">
                            <h3><?php echo $productos->nombre; ?></h3>
                            <p class="presentacion"><?php echo $productos->presentacion . ' ' . rtrim(rtrim(number_format($productos->cantidadPresentacion, 2), '0'), '.') . '' . $productos->medida->sigla . ' - ' . $productos->unidad_empaque . ' ' . rtrim(rtrim(number_format($productos->cantidad, 2), '0'), '.') . 'uds'; ?></p>

                            <form action="/pedido/carrito" method="POST">
                                <input name="id" type="hidden" value="<?php echo $productos->id; ?>">
                                <input name="categoriaId" type="hidden" value="<?php echo $productos->categoriaId; ?>">
                                <input name="nombre" type="hidden" value="<?php echo $productos->nombre; ?>">
                                <input name="presentacion" type="hidden" value="<?php echo $productos->presentacion; ?>">
                                <input name="cantidadPresentacion" type="hidden" value="<?php echo $productos->cantidadPresentacion; ?>">
                                <input name="medidaId" type="hidden" value="<?php echo $productos->medidaId; ?>">
                                <input name="unidad_empaque" type="hidden" value="<?php echo $productos->unidad_empaque; ?>">
                                <input name="cantidadEmpaque" type="hidden" value="<?php echo $productos->cantidad; ?>">
                                <p><span>Cantidad:</span></p>
                                <div class="campo campo-separado agregar-carrito div-flex">
                                    <div>
                                        <input name="cantidad" type="number" class="input-carrito cantidad" style="margin-top: 0;" value="1" min="1" required>
                                    </div>
                                    <div style="display: flex; flex-direction: row; gap: 1rem;">
                                        <button type="button" class="boton-exportar formulario agrega-carrito incremento">+</button>
                                        <button type="button" class="boton-exportar formulario agrega-carrito decremento">-</button>
                                    </div>
                                </div>
                                
                                <div class="campo campo-separado agregar-carrito">
                                    <button type="submit" class="boton-exportar formulario agrega-carrito">Agregar al carrito</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php } else { ?>
                <p class="alerta info">NO HAY PEDIDOS</p>
            <?php } ?>

            <p id="mensajeNoResultados" class="alerta info" style="display: none;">No se encontraron productos.</p>
        </div>
    </div>

    <script src="../build/js/pedidos.js"></script>


</section>
