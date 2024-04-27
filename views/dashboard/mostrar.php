<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu' ></i>
        <span class="text"> Dashboard</span>
    </div>
    <form action="/dashboard" class="form form-contenido form-dashboard" method="POST" enctype="multipart/form-data">
      
            <div class="cardline-flex">
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon rojo">
                        <a href="categoria">
                        <i class='bx bx-collection'></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Categorías</div>
                            <div class="card-contador"><?php echo strval($categoriaDash); ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon azul">
                        <a href="producto">
                            <i class='bx bx-package' ></i>
                        </a>                       
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Productos</div>
                            <div class="card-contador"><?php echo strval($productoDash); ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon teal">
                        <a href="pedido">
                            <i class='bx bx-cart'></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Ordenes de compra</div>
                            <div class="card-contador"><?php echo strval($pedidoDash) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon azulClaro">
                        <a href="stock">
                            <i class='bx bx-box' ></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Productos en Stock</div>
                            <div class="card-contador"><?php echo strval($stockDash) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon naranja">
                        <a href="inventario">
                            <i class='bx bx-history'></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Registros en Kardex</div>
                            <div class="card-contador"><?php echo strval($inventarioDash) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon rosaOscuro">
                        <a href="auth/mostrar">
                            <i class='bx bx-user' ></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Usuarios</div>
                            <div class="card-contador"><?php echo strval($usuarioDash) ?></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-box">
                        <div class="card-icon morado">
                        <a href="medida">
                            <i class='bx bx-ruler'></i>
                        </a>
                        </div>
                        <div class="card-contenido">
                            <div class="card-texto">Medidas</div>
                            <div class="card-contador"><?php echo strval($medidasDash) ?></div>
                        </div>
                    </div>
                </div>
            </div>  

            <div class="card-tabla-flex">
                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Registro de cantidad mínima</h3>
                        <div class="contenedor-tabla">
                            <table class="tabla" id="tabla">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Producto</th>
                                        <th>Presentación</th>
                                        <th>Cantidad</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach($stock as $stock) : ?>
                                        <?php if($stock->cantidad <= 100) {
                                            if($stock->cantidad <= 30){
                                                $clase = 'cantidad min';
                                            }
                                            if($stock->cantidad > 30){
                                                $clase = 'cantidad med';
                                            }?>
                                        
                                            <tr>
                                                <td data-titulo="Id"><?php echo $stock->id; ?></td> <!--  ID  -->
                                                <td data-titulo="Nombre"><?php echo $stock->producto->nombre?></td> <!--  Nombre  -->
                                                <td data-titulo="Presentación"><?php echo $stock->producto->presentacion;?></td> <!--  Presentación  -->
                                                <td data-titulo="Cantidad">
                                                    <a class="<?php echo $clase?>">
                                                        <?php echo $stock->cantidad; ?>
                                                    </a>
                                                </td> <!--  Cantidad -->   
                                                <td>
                                                    <div class="acciones-tabla">
                                                        <a class="boton-accion entrada" href="/stock/entradaStock?id=<?php echo $stock->id; ?>">
                                                        <i class="fa-solid fa-eye"></i> Ver
                                                        </a>
                                                    </div>
                                                </td>                                                           
                                            </tr>
                                        <?php } ?>
                                        
                                    <?php endforeach; ?>
                                <tbody>
                            </table>
                        </div>
                        
                        <div class="form form-contenido form-botones">
                            <a class="boton-exportar" href="stock"> Ver Stock</a>  
                        </div>
                    </div>
                </div>

                <div class="card-tabla">
                    <div class="card-contenedor">
                        <h3>Últimos movimientos</h3>
                        <div class="contenedor-tabla">
                            <table class="tabla" id="movimientos">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Referencia</th>
                                        <th>Producto</th>
                                        <th>Entrada</th>
                                        <th>Salida</th>
                                        <th>Cantidad Final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($inventario as $inventarios) : ?>
                                    <tr>
                                        <td data-titulo="Id"><?php echo $inventarios->id; ?></td> <!--  ID  -->
                                        <td data-titulo="Referencia"><?php echo $inventarios->referencia; ?></td> <!--  Referencia  -->
                                        <td data-titulo="Nombre"><?php echo $inventarios->producto->nombre; ?></td> <!--  Nombre  -->
                                        <td data-titulo="Entrada">  <?php echo $inventarios->cantidadEntrada; ?></td> <!--  Cantidad Entrada  -->
                                        <td data-titulo="Salida">  <?php echo $inventarios->cantidadSalida; ?></td> <!--  Cantidad Salida  -->
                                        <td data-titulo="Total"><?php echo $inventarios->cantidadTotal; ?></td> <!--  Cantidad Total  -->                                                    
                                    </tr>
                                    <?php endforeach; ?>
                                <tbody>
                            </table>
                        </div>
                        <div class="form-botones final">
                            <a class="boton-exportar" href="inventario">Ver Movimientos</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-tabla contenedor-pedidos">
                <div class="card-contenedor card-pedidos">
                    <h3>Pedidos Recientes</h3>
                    <div class="contenedor-tabla">
                        <table class="tabla" id="pedidos">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Referencia</th>
                                <th>Categoria</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Observacion</th>
                                <th>Estado</th>
                                <th>Creado Por</th>
                                <th>Fecha de Creación</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                            <tbody>
                                <?php foreach($pedido as $pedidos) : ?>
                                <tr>
                                <td data-titulo="Id"><?php echo $pedidos->id; ?></td>
                                <td data-titulo="Referencia"><?php echo $pedidos->referencia; ?></td>
                                <td data-titulo="Nombre"><?php echo $pedidos->categoria->nombre; ?></td>
                                <td data-titulo="Producto"><?php echo $pedidos->producto->nombre; ?></td>
                                <td data-titulo="Cantidad"><?php echo $pedidos->cantidad; ?></td>
                                <td data-titulo="Detalle" data-detalle="Detalle"><?php echo $pedidos->observacion; ?></td>
                                <td data-titulo="Estado">
                                    <?php if($pedidos->estado === 'Aceptado') : ?>
                                        <a class="estado aceptado"> Aceptado </a>
                                    <?php elseif($pedidos->estado === 'Rechazado'): ?>
                                        <a class="estado rechazado"> Rechazado </a>
                                    <?php else: ?>
                                        <a class="estado pendiente"> Pendiente </a>
                                    <?php endif ?>              
                                </td>
                                <td data-titulo="Creador"><?php echo $pedidos->usuario->nombre . " " . $pedidos->usuario->apellido  ; ?></td>
                                <td data-titulo="Creado"><?php echo $pedidos->fechaCreacion; ?></td>
                                <td>
                                    <div class="acciones-tabla">
                                        <a class="boton-accion entrada" href="/pedido/actualizar?id=<?php echo $pedidos->id; ?>">
                                            <i class="fa-solid fa-eye"></i> Ver Pedido
                                        </a>                  
                                    </div>
                                </td>
                                <td>
                                    <div class="acciones-tabla">
                                        <a class="boton-accion salida" href="/pedido/gestionaReferencia?referencia=<?php echo $pedidos->referencia; ?>">
                                            <i class="fa-solid fa-eye"></i> Ver Referencia
                                        </a>                  
                                    </div>
                                </td>  
                                </tr>
                                <?php endforeach; ?>
                            <tbody>
                        </table>
                    </div>
                    <div class="form-botones final">
                        <a class="boton-exportar" href="pedido">Ver Pedidos</a>
                    </div>
                </div>
            </div>


    <div class="contenedor-dashboard">
        <div class="dashboard-row">

            <div class="dashboard-info">
            <div class="wrap">
                <a href="pedido" class="dashboard-info__titulo">Pedidos de Compra
                <i class='bx bxs-info-circle'></i>
                </a>
                <span class="dashboard-info__contar"><?php echo strval($pedidoDash) ?></span>
                <span class="dashboard-info__subInfo">Pendiente:  <?php echo strval($pedidoPendiente) ?></span>
                <span class="dashboard-info__subInfo">Aceptado:  <?php echo strval($pedidoAceptado) ?></span>
                <span class="dashboard-info__subInfo">Rechazado:  <?php echo strval($pedidoRechazado) ?></span>
            </div>
            </div>  <!-- CONTENEDOR PEDIDOS -->


            <div class="dashboard-info">
            <div class="wrap">
                <a href="inventario" class="dashboard-info__titulo">Inventario
                <i class='bx bxs-info-circle'></i>
                </a>
                <span class="dashboard-info__contar"><?php echo strval($inventarioDash) ?></span>
                <span class="dashboard-info__subInfo">Entradas: <?php echo strval($inventarioEntrada) ?></span>
                <span class="dashboard-info__subInfo">Salidas: <?php echo strval($inventarioSalida) ?></span>
            </div>
            </div>  <!-- CONTENEDOR INVENTARIO -->

            <div class="dashboard-info">
            <div class="wrap">
                <a href="auth/mostrar" class="dashboard-info__titulo">Usuarios
                <i class='bx bxs-info-circle'></i>
                </a>
                <span class="dashboard-info__contar"><?php echo strval($usuarioDash) ?></span>
                <span class="dashboard-info__subInfo">Encargado: <?php echo strval($usuarioAdministrador) ?></span>
                <span class="dashboard-info__subInfo">Administrador: <?php echo strval($usuarioEncargado) ?></span>
            </div>
            </div>  <!-- CONTENEDOR USUARIOS -->


        </div>
    </div>

    </form> 

  </section>   
