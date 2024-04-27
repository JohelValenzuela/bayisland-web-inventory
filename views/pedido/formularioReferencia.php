
<div style="width: inherit;">
    <table class="tabla" id="tabla">
        <h2 style="color: black; margin-bottom: 5rem;">Resumen de Referencia</h2>
        
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
                <th>Cant. Pedida</th>
                <th>Creado Por</th>
                <th>Fecha de Creación</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach($pedido as $pedidos) : ?>
            <tr>
                <td data-titulo="Id"><?php echo $pedidos->id; ?></td>
                <td data-titulo="Referencia"><?php echo $pedidos->referencia; ?></td>
                <td data-titulo="Categoria"><?php echo $pedidos->categoria->nombre; ?></td>
                <td data-titulo="Producto"><?php echo $pedidos->producto->nombre; ?></td>

                <td data-titulo="Presentacion"><?php echo $pedidos->producto->presentacion; ?></td>
                <td data-titulo="Cantidad Presentacion"><?php echo $pedidos->producto->cantidadPresentacion; ?></td>

                <td data-titulo="Medida"><?php echo $pedidos->medida->nombre; ?></td>

                <td data-titulo="Empaque"><?php echo $pedidos->producto->unidad_empaque; ?></td>

                <td data-titulo="Cantidad por Empaque"><?php echo $pedidos->producto->cantidad; ?></td>

                <td data-titulo="Empaque"><?php echo $pedidos->cantidad; ?></td>

                <td data-titulo="Creador"><?php echo $pedidos->usuario->nombre . " " . $pedidos->usuario->apellido  ; ?></td>
                <td data-titulo="Creado"><?php echo $pedidos->fechaCreacion; ?></td>

            </tr>
        <?php endforeach; ?>
        <tbody>   
    </table>
</div>
<label class="label-pedido" for="cantidad" ><strong>Cantidad Pedida:</strong> <?php echo s($pedidos->cantidad . " " . $pedidos->producto->unidad_empaque); ?></label>
<input name="referencia" id="referencia" type="hidden" value="<?php echo s($_POST['referencia']) ?>"/>

<div class="div-flex" >
    <div class="campo campo-separado w-20">
        <label for="cantidad" >Cantidad</label>
        <input disabled name="cantidad" id="cantidad" type="text" placeholder="Ingrese la cantidad aceptada"  value="<?php echo s($pedidos->cantidad) ?>"/>
    </div>

    <div class="campo campo-separado w-60">
        <label for="observacion">Observaciones</label>
        <input name="observacion" id="observacion" type="text" placeholder="Observaciones" value="<?php echo s($pedidos->observacion) ?>"/>
    </div>

    <div class="campo campo-separado w-20">
        <label for="estado" >Estado</label>
        <select name="estado" id="estado">
            <option selected value>-- Seleccione --</option>
            <option value="<?php echo s($pedidos->estado = 'Aceptado') ?>">Aceptar</option>
            <option value="<?php echo s($pedidos->estado = 'Rechazado') ?>" >Rechazar</option>               
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
