<form action="/recetas/carritoIngredientes" method="POST">
    <div class="div-flex">
        <div class="campo campo-separado w-20">
            <label for="recetaId">Seleccionar Receta:</label>
            <select class="buscar" name="recetaId" required>
            <option value="">-- Seleccione Receta --</option>
                <?php

use Model\Producto;
use Model\Receta;

 foreach ($recetas as $receta): ?>
                    <option value="<?php echo $receta->id; ?>"><?php echo $receta->nombre; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="campo campo-separado w-40">
            <label for="productoId">Seleccionar Producto:</label>
            <select class="buscar" name="productoId" required>
            <option value="">-- Seleccione un Producto --</option>
                <?php foreach ($productos as $producto): ?>
                    <option value="<?php echo $producto->id; ?>"><?php echo $producto->nombre; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="campo campo-separado w-20">
            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" min="0.1" step="0.1" value="0.0" required>
        </div>

        <div class="campo campo-separado w-20">
            <label for="cantidad">Agregar</label>
            <input type="submit" value="Agregar Ingrediente" class="boton-exportar formulario">
        </div>
    </div>
</form>

<section class="form form-contenido form-flex">
    <?php if(!empty($orden)): ?>
        <div style="width: inherit;">
            <h2 style="color: black; margin-bottom: 5rem;">Lista de Ingredientes de Receta</h2>
        </div>
        
        <table class="tabla table_id" id="">
            <thead>
                <tr>
                    <th>Receta</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orden as $item): ?>
                    <tr>
                        <td><?php echo Receta::find($item['recetaId'])->nombre; ?></td>
                        <td><?php echo Producto::find($item['nombre'])->nombre; ?></td>
                        <td><?php echo $item['cantidad']; ?></td>
                        <td>
                            <form action="/recetas/eliminarIngredienteCarrito" method="POST" style="display:inline;">
                                <input type="hidden" name="productoId" value="<?php echo $item['productoId']; ?>">
                                <input type="submit" value="Eliminar" class="boton-exportar cerrar">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <form action="/recetas/vaciarCarritoIngredientes" method="POST" style="margin-top: 20px;">
            <div class="campo campo-separado">
                <input type="submit" value="Vaciar Lista" class="boton-exportar formulario">
            </div>    
        </form>
    <?php endif; ?>

    <form action="/recetas/guardarRecetaIngredientes" method="POST">
        <div class="campo campo-separado">
            <input type="submit" value="Crear Receta" class="boton-exportar formulario">
        </div>
    </form>

</section>
