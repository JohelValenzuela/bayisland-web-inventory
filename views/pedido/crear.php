<section class="home-section" style="height: auto; background: white;">
    <?php include __DIR__ . '/navcarrito.php' ?>
    <?php include_once __DIR__ . "/../templates/alertas.php";?>

    <section class="display-buscador">
        

        
    </section>

    <form class="form form-contenido form-botones">
    <div class="campo campo-separado buscador">
    <label for="filtroCategoria">Filtrar por Categoría:</label>
            <input type="text" id="inputBusqueda" class="campo-buscar" placeholder="Buscar productos...">
            <span id="btnClear" class="clear-button">&#10005;</span>
        </div>
        <div class="campo campo-separado">
            <label for="filtroCategoria">Filtrar por Categoría:</label>
            <select id="filtroCategoria" class="filtro-categoria">
                <option value="">Todas las categorías</option>
                <?php foreach($categoria as $categoria):  ?>
                    <option value="<?php echo s($categoria->id); ?>" ><?php echo s($categoria->nombre); ?> </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <div class="productos-container">
        <?php if(!empty($producto)) { ?>
            <?php foreach($producto as $productos) : ?>
                <div class="producto-card" data-categoria="<?php echo $productos->categoria->id; ?>">
                <img src="/build/img/marsol.webp" alt="<?php echo $productos->nombre; ?>">
                    <div class="producto-info">
                        <h3><?php echo $productos->nombre; ?></h3>
                        <p><strong>Categoría:</strong> <?php echo $productos->categoria->nombre; ?></p>
                        <p><strong>Presentación:</strong> <?php echo $productos->presentacion . ' ' . $productos->cantidadPresentacion . ' ' . $productos->medida->sigla; ?></p>
                        <p><strong>Por Empaque:</strong> <?php echo $productos->cantidad . 'uds'; ?></p>
                        <p><strong>Precio:</strong> $<?php echo 'precio'; ?></p>

                        <form action="/pedido/carrito" method="POST">
                            <input name="id" type="hidden" value="<?php echo $productos->id; ?>">
                            <input name="categoriaId" type="hidden" value="<?php echo $productos->categoriaId; ?>">
                            <input name="nombre" type="hidden" value="<?php echo $productos->nombre; ?>">
                            <input name="presentacion" type="hidden" value="<?php echo $productos->presentacion; ?>">
                            <input name="cantidadPresentacion" type="hidden" value="<?php echo $productos->cantidadPresentacion; ?>">
                            <input name="medidaId" type="hidden" value="<?php echo $productos->medidaId; ?>">
                            <input name="unidad_empaque" type="hidden" value="<?php echo $productos->unidad_empaque; ?>">
                            <input name="cantidadEmpaque" type="hidden" value="<?php echo $productos->cantidad; ?>">
                            <p><strong>Cantidad:</strong></p>
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

    <script>
        // JavaScript para filtrar productos por categoría
        document.addEventListener('DOMContentLoaded', function() {
            const botonesIncremento = document.querySelectorAll('.incremento');
            const botonesDecremento = document.querySelectorAll('.decremento');
            const inputsCantidad = document.querySelectorAll('.cantidad');

            botonesIncremento.forEach(boton => {
                boton.addEventListener('click', function() {
                    incrementarCantidad(this);
                });
            });

            botonesDecremento.forEach(boton => {
                boton.addEventListener('click', function() {
                    decrementarCantidad(this);
                });
            });

            function incrementarCantidad(boton) {
                let inputCantidad = boton.parentElement.previousElementSibling.querySelector('.cantidad');
                let cantidadActual = parseInt(inputCantidad.value);
                inputCantidad.value = cantidadActual + 1;
            }

            function decrementarCantidad(boton) {
                let inputCantidad = boton.parentElement.previousElementSibling.querySelector('.cantidad');
                let cantidadActual = parseInt(inputCantidad.value);
                if (cantidadActual > 1) {
                    inputCantidad.value = cantidadActual - 1;
                }
            }

            // Implementar el buscador
            const inputBusqueda = document.getElementById('inputBusqueda');
            const btnClear = document.getElementById('btnClear');
            const mensajeNoResultados = document.getElementById('mensajeNoResultados');
            const productos = document.querySelectorAll('.producto-card');

            inputBusqueda.addEventListener('input', function() {
                filtrarProductos();
            });

            const filtroCategoria = document.getElementById('filtroCategoria');
            filtroCategoria.addEventListener('change', function() {
                filtrarProductos();
            });

            function filtrarProductos() {
                const valorBusqueda = inputBusqueda.value.trim().toLowerCase();
                const valorCategoria = filtroCategoria.value;

                productos.forEach(producto => {
                    const nombreProducto = producto.querySelector('h3').textContent.toLowerCase();
                    const categoriaProducto = producto.dataset.categoria;

                    const cumpleBusqueda = nombreProducto.includes(valorBusqueda) || valorBusqueda === '';
                    const cumpleCategoria = valorCategoria === '' || categoriaProducto === valorCategoria;

                    if (cumpleBusqueda && cumpleCategoria) {
                        producto.style.display = 'block';
                    } else {
                        producto.style.display = 'none';
                    }
                });

                // Mostrar u ocultar el mensaje de no resultados
                const algunProductoVisible = Array.from(productos).some(producto => producto.style.display !== 'none');
                mensajeNoResultados.style.display = algunProductoVisible ? 'none' : 'block';
            }

            // Función para borrar el campo de búsqueda
            btnClear.addEventListener('click', function() {
                inputBusqueda.value = '';
                filtrarProductos();
            });
        });
    </script>

</section>
