
<?php

use Model\UnidadMedida;

    if(isset($_SESSION["carrito"])){              
        $orden = $_SESSION["carrito"];
    }

    // Contar Carrito
    if(isset($_SESSION["carrito"])){ // TIENE ALGO - ENTRA AL FOR
        for($i=0;$i<=count($orden)-1;$i ++){
            if(isset($orden[$i])){
                if($orden[$i]!=NULL){

                    if(!isset($cuantos)){ // NO está definida y no es Null
                        $cuantos = "0";
                    }
                        
                    $total_cantidad = $cuantos;
                    $total_cantidad ++ ;

                    if(!isset($totalcantidad)){
                        $totalcantidad = "0";
                    }

                    $totalcantidad += $total_cantidad;
                }
            }
        }
    }

    //declaramos variables
    if(!isset($totalcantidad)){
        $totalcantidad = 0;
    }

?>

<div class="flex-carrito">
    <div class="flex-carrito">
        <div class="home-content">
            <i class='bx bx-menu' ></i>
            <span class="text"> Crear Pedido</span>
        </div>
        <div class="home-carrito">
            <a href="<?= $_SERVER["HTTP_REFERER"]?>" class="boton-exportar volver"> Regresar  <i class="fa-solid fa-person-walking-arrow-loop-left"></i> </a>
        </div>
    </div>

    <div class="home-carrito">
        <a href="#openModal" class="boton-accion carrito"> 
            <i class='bx bxs-shopping-bags carrito'></i>
            <?php echo $totalcantidad; ?>
        </a>
    </div>
</div>

<?php 
// Resetea el carrito siempre que esté vacío
    if($totalcantidad <= 0){
        unset($_SESSION["carrito"]);
    }
?>

<?php if($totalcantidad > 0 ) { ?>
<!-- Si hay algo en el carrito, lo muestra en el modal-carrito -->
    <div id="openModal" class="modalDialog">

        <div style="width: fit-content;">
            <a href="#cierra" title="Cerrar" class="cierra">X</a>
            <h2>Orden de Compra</h2>
            <!-- <p> * Los productos añadidos a la orden de compra tendrán por defecto una cantidad mínima de 1 unidad. </p>
            <p> * Para agregar una cantidad personalizada digite la cantidad en el espacio disponible y posteriormente pulse en el botón guardar <spam style="color: green"> <i class="fa-regular fa-square-plus agrega"></i></spam>  </p> 
            <p> * Para eliminar un producto pulse en el botón eliminar <spam style="color: red"> <i class='bx bxs-trash borra'></i></spam>  </p> -->

    <div style="border: 1px solid black;">

    
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
                    <?php if($totalcantidad > 0 ) {  
                        if(isset($_SESSION["carrito"])){
                            $lleno = 'lleno';
                            //debug($_SESSION["carrito"]);
                            for($i=0;$i<=count($orden)-1;$i ++){
                                if(isset($orden[$i])){
                                    if($orden[$i] != 0){     ?>

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

                                            <!-- <td> 
                                                <form class="no-margin" action="/pedido/editarCarrito" method="POST"> 
                                                    <div class="acciones-tabla">
                                                        <input type="hidden" name="id" value="<?php echo $i; ?>">
                                                        <input class="input-carrito" type="number" name="cantidad" value="<?php echo $orden[$i]["cuantos"]; ?>">
                                                        <button type="submit" class="boton-accion editar">
                                                            <i class="fa-regular fa-square-plus agrega"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>     -->
                                            
                                            <!-- <td> <?php echo $orden[$i]["id"];?></td> -->
                                            <!-- <td> <?php echo $orden[$i]["categoriaId"];?></td> -->
                                            <td style="width: 305.58px;"> <?php echo $orden[$i]["nombre"] . ' - ' .$orden[$i]["presentacion"] . " - " . $orden[$i]["cantidadPresentacion"] . ' ' . UnidadMedida::find($orden[$i]["medidaId"])->sigla; ?></td>
                                            
                                            <td style="width: 124.895px;"> <?php echo $orden[$i]["unidad_empaque"] . ' ' . $orden[$i]["cantidad"]; ?></td>
                                            
                                        </tr>


                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                <tbody>
            </table>
            </div>
                        <?php } ?>   
                    <?php } else { ?>       
                        <p class="alerta info">NO HAY NADA EN EL CARRITO</p>
                    <?php } ?>

            <div class="modal-footer" style="display: flex; gap: 2rem; margin-top: 1rem; padding: 1rem; justify-content: center;">
                <a href="#cierra" title="Cerrar" class="boton-exportar cerrar">Cerrar</a>
                <a href="borrarCarrito" class="boton-exportar vaciar"><i class='bx bxs-trash borra'></i> Vaciar carrito</a>
                <form class="no-margin" action="/pedido/guardaPedido" method="POST"> 
                    <button type="submit" class="boton-exportar continuar"> 
                    Enviar Pedido <i class='bx bx-send'></i> 
                    </button>
                </form>  
            </div>

        </div>

            
        
    </div>    

<?php } ?>

