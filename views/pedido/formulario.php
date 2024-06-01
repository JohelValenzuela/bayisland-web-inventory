
<div style="width: inherit;">
    <table class="tabla" id="tabla">
        <h2 style="color: black; margin-bottom: 5rem;">Detalle del producto</h2>
        <thead>
        <tr>  
            <th>ID</th>
            <th>ID Maestro</th>
            <th>Producto</th>
            <th>Presentación</th>
            <th>Cant. Presentación</th>
            <th>Medida</th>
            <th>Total medida</th>
            <th>Cantidad</th>
            <th>Observacion</th>
        </tr>
        </thead>

        <tbody>
            <tr>
                <td data-titulo="Id"><?php echo $detalle->id; ?></td>
                <td data-titulo="Maestro"><?php echo $detalle->maestroId; ?></td>
                <td data-titulo="Producto"><?php echo $detalle->producto->nombre; ?></td>
                <td data-titulo="Producto"><?php echo $detalle->producto->presentacion; ?></td>
                <td data-titulo="Producto"><?php echo $detalle->producto->cantidadPresentacion; ?></td>
                <td data-titulo="Producto"><?php echo $detalle->medida->nombre; ?></td>
                <td data-titulo="Producto"><?php echo $detalle->producto->totalMedida; ?></td>
                <td data-titulo="Cantidad"><?php echo $detalle->cantidad; ?></td>
                <td data-titulo="Observacion"><?php echo $detalle->observacion; ?></td>
            </tr>
        <tbody>   
    </table>
</div>

<label class="label-pedido" for="cantidad" ><strong>Cantidad Pedida:</strong> <?php echo s($detalle->cantidad); ?></label>


<div class="div-flex" >
    <div class="campo campo-separado w-20">
        <label for="cantidad" >Cantidad</label>
        <input  name="cantidad" id="cantidad" type="text" placeholder="Ingrese la cantidad aceptada"  value="<?php echo s($detalle->cantidad) ?>"/>
    </div>

    <div class="campo campo-separado w-80">
        <label for="observacion">Observaciones</label>
        <input name="observacion" id="observacion" type="text" placeholder="Observaciones" value="<?php echo s($detalle->observacion) ?>"/>
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
