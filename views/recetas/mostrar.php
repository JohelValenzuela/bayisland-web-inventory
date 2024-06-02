<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text">Recetas</span>
    </div>

    <form class="form form-contenido form-botones">
        <a class="boton-exportar" href="/recetas/crear"> <i class="fa-regular fa-square-plus"></i> Crear Receta</a>

        <a class="boton-exportar" href="carritoIngredientes"> <i class="fa-regular fa-square-plus"></i> Agregar Ingredientes</a>


        <a class="boton-exportar pdf" href="" target="_blank"> <i class="fa-solid fa-file-pdf"></i> PDF</a>  


        <button id="btnExportar" class="boton-exportar">
            <i class="fa-solid fa-file-excel"></i> EXCEL
        </button>

        <a class="boton-exportar print" href="" target="_blank"> <i class="fa-solid fa-print"></i> Imprimir</a>   

    </form>


    <form action="/recetas/crear" class="form form-contenido form-tabla" enctype="multipart/form-data">

    <table class="tabla" id="tabla1">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Receta</th>
            <th>Observacion</th>
            <th>Editar</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($recetas)){ ?>
            <?php foreach($recetas as $receta) : ?> 
                <?php
                    // Verificar si el botón "Ver Más" está presionado para esta receta
                    $action = isset($_GET['action']) ? $_GET['action'] : ''; // Variable para almacenar la acción actual
                    $isVerMas = ($action == 'ver_mas' && isset($_GET['id']) && $_GET['id'] == $receta->id);
                ?>
                <tr>
                    <td>
                        <div class="acciones-tabla">
                            <?php if(!$isVerMas) : ?> <!-- Mostrar el botón "Ver Más" solo si no se está mostrando la tabla -->
                                <a class="boton-accion entrada" href="?id=<?php echo $receta->id; ?>&action=ver_mas">
                                    <i class="fa-regular fa-eye accion toggle-on"></i>
                                </a>
                            <?php else: ?> <!-- Si se está mostrando la tabla, mostrar el botón "Ocultar" -->
                                <a class="boton-accion salida" href="?id=<?php echo $receta->id; ?>&action=ocultar">
                                    <i class="fa-regular fa-eye-slash accion toggle-off"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td data-titulo="Id"><?php echo $receta->id; ?></td>
                    <td data-titulo="Categoria"><?php echo $receta->nombre;?></td>
                    <td data-titulo="Producto"><?php echo $receta->observacion; ?></td>
                    
                    <td>
                        <div class="acciones-tabla">
                            <a class="boton-accion editar" href="/producto/actualizar?id=<?php echo $receta->id; ?>">
                                <i class="fa-regular fa-pen-to-square accion"></i>  
                            </a>                    
                        </div>
                    </td>
                </tr>
                <?php if($isVerMas) : ?>
                    <tr>
                        <td colspan="8"> <!-- colspan 8 para cubrir todas las columnas -->
                            <table class="tabla" id="tabla2">
                                <thead>
                                    <tr>  
                                        <th>ID</th>
                                        <!-- <th>Receta</th> -->
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php 
                                        $ingredienteRecetaEncontrado = false;
                                        foreach($ingredientesReceta as $ingredienteReceta) : 
                                            if($ingredienteReceta->recetaId == $receta->id) {
                                                $ingredienteRecetaEncontrado = true;
                                    ?>
                                            <tr>
                                                <td data-titulo="Id"><?php echo $ingredienteReceta->id; ?></td>
                                                <!-- <td data-titulo="Receta">< ?php echo $ingredientes->receta->nombre;?></td> -->
                                                <td data-titulo="Producto"><?php echo $ingredienteReceta->producto->nombre; ?></td>
                                                <td data-titulo="Cantidad"><?php echo $ingredienteReceta->cantidad; ?></td>
                                            </tr>
                                    <?php 
                                            }
                                        endforeach; 
                                        if (!$ingredienteRecetaEncontrado) {
                                    ?>
                                            <tr>
                                                <td colspan="3" class="sin-registro">
                                                    <a class="sin-registro">Sin ingredientes</a>
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




