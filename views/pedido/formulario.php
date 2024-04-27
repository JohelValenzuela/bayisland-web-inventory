
<div style="width: inherit;">
    <table class="tabla" id="tabla">
        <h2 style="color: black; margin-bottom: 5rem;">Resumen de Pedido</h2>
        <thead>
            <tr>
                <th>ID</th>
                <th>Referencia</th>
                <th>Categoria</th>
                <th>Producto</th>
                <th>Presentación</th>
                <th>Cant. Presentación</th>
                <th>Medida</th>
                <th>Tipo Empaque</th>
                <th>Cant. Empaque</th>
                <th>Creado Por</th>
                <th>Fecha de Creación</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td data-titulo="Id"><?php echo $pedido->id; ?></td>
                <td data-titulo="Referencia"><?php echo $pedido->referencia; ?></td>
                <td data-titulo="Categoria"><?php echo $pedido->categoria->nombre; ?></td>
                <td data-titulo="Producto"><?php echo $pedido->producto->nombre; ?></td>

                <td data-titulo="Presentacion"><?php echo $pedido->producto->presentacion; ?></td>
                <td data-titulo="Cantidad Presentacion"><?php echo $pedido->producto->cantidadPresentacion; ?></td>

                <td data-titulo="Medida"><?php echo $pedido->medida->nombre; ?></td>

                <td data-titulo="Empaque"><?php echo $pedido->producto->unidad_empaque; ?></td>
                <td data-titulo="Cantidad por Empaque"><?php echo $pedido->producto->cantidad; ?></td>

                <td data-titulo="Creador"><?php echo $pedido->usuario->nombre . " " . $pedido->usuario->apellido  ; ?></td>
                <td data-titulo="Creado"><?php echo $pedido->fechaCreacion; ?></td>

            </tr>
        <tbody>   
    </table>
</div>

<label class="label-pedido" for="cantidad" ><strong>Cantidad Pedida:</strong> <?php echo s($pedido->cantidad . " " . $pedido->producto->unidad_empaque); ?></label>


<div class="div-flex" >
    <div class="campo campo-separado w-20">
        <label for="cantidad" >Cantidad</label>
        <input  name="cantidad" id="cantidad" type="text" placeholder="Ingrese la cantidad aceptada"  value="<?php echo s($pedido->cantidad) ?>"/>
    </div>

    <div class="campo campo-separado w-60">
        <label for="observacion">Observaciones</label>
        <input name="observacion" id="observacion" type="text" placeholder="Observaciones" value="<?php echo s($pedido->observacion) ?>"/>
    </div>

    <div class="campo campo-separado w-20">
        <label for="estado" >Estado</label>
        <select name="estado" id="estado">
            <option selected value>-- Seleccione --</option>
            <option value="<?php echo s($pedido->estado = 'Aceptado') ?>">Aceptar</option>
            <option value="<?php echo s($pedido->estado = 'Rechazado') ?>" >Rechazar</option>               
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
