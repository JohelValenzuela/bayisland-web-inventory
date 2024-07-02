<?php

use Model\UnidadMedida;

$totalcantidad  = 0;

if(isset($_SESSION["carrito"])){              
    $orden = $_SESSION["carrito"];
}

// Resetear el carrito siempre que esté vacío
if(!empty($totalcantidad)){
    if($totalcantidad <= 0){
        unset($_SESSION["carrito"]);
    }
}

// Contar Carrito
if(isset($_SESSION["carrito"])){ // TIENE ALGO - ENTRA AL FOR
    for($i=0; $i <= count($orden); $i++){
        if(isset($orden[$i]) && $orden[$i] != NULL){
       
            $totalcantidad+= $orden[$i]["cuantos"];

        }
    }
}

?>

<div class="flex-carrito">
    <div class="flex-carrito">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <span class="text">Crear Pedido</span>
        </div>
        <div class="home-carrito">
            <a href="<?= $_SERVER["HTTP_REFERER"]?>" class="boton-exportar volver">Regresar <i class="fa-solid fa-person-walking-arrow-loop-left"></i></a>
        </div>
    </div>

    <div class="home-carrito">
        <a href="#openModal" class="boton-accion carrito"> 
            <i class='bx bx-cart carrito'></i>
            <?php echo $totalcantidad ?? 0; ?>
        </a>
    </div>
</div>
<?php if(!empty($totalcantidad)) { ?>
<?php if($totalcantidad > 0) { ?>
<!-- Si hay algo en el carrito, lo muestra en el modal-carrito -->
<div id="openModal" class="modalDialog">

    <div style="width: fit-content;">
        <a href="#cierra" title="Cerrar" class="cierra">X</a>
        <h2>Orden de Compra</h2>
        <div class="campo campo-unido">
            <?php include_once __DIR__ . "/../templates/alertas.php";?>
        </div>
        <form action="/pedido/guardaPedido" method="POST">
            <label for="bodegaId">Selecciona la Bodega:</label>
            <div class="campo campo-separado" style="position: relative; z-index: 1000;">
                <select class="buscar" name="bodegaId" id="bodegaId" style="width: 100%; box-sizing: border-box;">
                    <option selected disabled value="">-- Seleccione Bodega --</option>
                    <?php foreach ($bodega as $bodegas) : ?>
                        <option value="<?php echo $bodegas->id; ?>"><?php echo $bodegas->nombre . " - " . $bodegas->ubicacion; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <table class="tabla table_id" id="tablaCarrito" style="color: #1a1b15; width: 100%; position: relative; display: table-header-group;">
                <thead>
                    <tr>
                        <th style="width: 75px;"></th>
                        <th style="width: 100px;">Cantidad</th>
                        <th style="width: 305.58px;">Producto</th>
                        <th style="width: 124.895px;">Empaque</th>
                    </tr>
                </thead>
                <tbody style="display: block; height: 400px; overflow: auto;">
                
                    <?php if($totalcantidad > 0) {  
                        if(isset($_SESSION["carrito"])){
                            $lleno = 'lleno';
                            for($i=0; $i <= count($orden); $i++){
                                if(isset($orden[$i]) && $orden[$i] != 0){ ?>

                                    <tr>
                                        <td style="width: 75px;">
                                            <form class="no-margin" action="/pedido/eliminarProductoCarrito" method="POST"> 
                                                <input type="hidden" name="id" value="<?php echo $i; ?>">
                                                <button type="submit" class="boton-accion eliminar">
                                                    <i class='bx bxs-trash borra'></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td style="width: 100px;"><?php echo $orden[$i]["cuantos"] ?> </td>

                                        <td style="width: 305.58px;"> <?php echo $orden[$i]["nombre"] . ' - ' .$orden[$i]["presentacion"] . " - " . $orden[$i]["cantidadPresentacion"] . ' ' . UnidadMedida::find($orden[$i]["medidaId"])->sigla; ?></td>
                                        
                                        <td style="width: 124.895px;"> <?php echo $orden[$i]["unidad_empaque"] . ' ' . $orden[$i]["cantidad"]; ?></td>
                                    </tr>

                                <?php } ?>
                            <?php } ?>
                        <?php } ?>   
                    <?php } else { ?>       
                        <p class="alerta info">NO HAY NADA EN EL CARRITO</p>
                    <?php } ?>
                </tbody>
            </table>

            <div class="modal-footer" style="display: flex; gap: 2rem; margin-top: 1rem; padding: 1rem; justify-content: center;">
                <a href="#cierra" title="Cerrar" class="boton-exportar cerrar">Cerrar</a>
                <a href="borrarCarrito" class="boton-exportar vaciar"><i class='bx bxs-trash borra'></i> Vaciar carrito</a>
                <button type="submit" class="boton-exportar continuar">Enviar Pedido <i class='bx bx-send'></i></button>
            </div>
        </form>
    </div>
</div>
<?php } ?>
<?php } ?>


