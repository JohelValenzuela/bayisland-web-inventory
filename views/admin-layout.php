<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistema de Inventario Web</title>
        <link rel="shortcut icon" href="/build/img/logo.webp"/>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="../build/css/app.css">
        <link rel="stylesheet" href="../build/css/style.css">
        <link rel="stylesheet" href="../build/css/datatables.css">
        <link rel="stylesheet" href="../build/css/select.css">
        <link rel="stylesheet" href="../build/css/responsive.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>

    <body>
        <div class="sidebar close">
            <div class="logo-detalle">
                <i class='bx bxs-ship'></i>
            </div>
                <ul class="enlace-navegacion">
                    <li>
                        <a href="/dashboard"  id="myLink">
                            <i class='bx bx-grid-alt' ></i>
                            <span class="enlace-texto">Dashboard</span>
                        </a>
                        <ul class="sub-menu blank">
                            <li><a class="enlace-texto" href="/dashboard">Dashboard</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="/categoria">
                            <i class='bx bx-collection'></i>
                            <span class="enlace-texto">Categoría</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a class="enlace-texto" href="/categoria">Categoría</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="/producto">
                            <i class='bx bx-package' ></i>
                            <span class="enlace-texto">Producto</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a class="enlace-texto" href="/producto">Producto</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="/recetas/mostrar">
                            <i class='bx bx-food-menu'></i>
                            <span class="enlace-texto">Recetas</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a class="enlace-texto" href="/producto">Recetas</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="/ventas">
                            <i class='bx bxs-shopping-bags'></i>
                            <span class="enlace-texto">Ventas</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a class="enlace-texto" href="/producto">Ventas</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="/ventas_ultima_hora">
                            <i class='bx bx-money'></i>
                            <span class="enlace-texto">Ventas Extra</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a class="enlace-texto" href="/producto">Ventas Última Hora</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="/pedido">
                            <i class='bx bx-cart'></i>
                            <span class="enlace-texto">Pedido</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a class="enlace-texto" href="#">Pedido</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="/stock">
                            <i class='bx bx-box' ></i>
                            <span class="enlace-texto">Stock</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a class="enlace-texto" href="#">Stock</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="/inventario">
                            <i class='bx bx-history'></i><!-- <i class='bx bx-book-alt'></i> -->
                            <span class="enlace-texto">Kardex</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a class="enlace-texto" href="#">Kardex</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="/reportesDefectos">
                            <i class='bx bx-repost'></i>
                            <span class="enlace-texto">Reportar Daños</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a class="enlace-texto" href="/reportesDefectos">Reportar Daños</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="/regalias">
                            <i class='bx bx-gift' ></i>
                            <span class="enlace-texto">Reportar Regalía</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a class="enlace-texto" href="/regalias">Reportar Regalía</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="/pasajeros">
                            <i class='bx bx-bus'></i>
                            <span class="enlace-texto">Reportar Pasajeros</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a class="enlace-texto" href="/regalias">Reportar Pasajeros</a></li>
                        </ul>
                    </li>

                    <li><a href="/auth/mostrar">
                            <i class='bx bx-user' ></i>
                            <span class="enlace-texto">Usuarios</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a class="enlace-texto" href="/auth/mostrar">Usuarios</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="/medida">
                            <i class='bx bx-ruler'></i>
                            <span class="enlace-texto">Medidas</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a class="enlace-texto" href="/medida">Unidades de Medida</a></li>
                        </ul>
                    </li>
                    
                    <li>
                        <div class="perfil-detalle">
                            <div class="profile-content">
                                
                            </div>
                            <a href="/auth/logout">
                                <i class='bx bx-log-out logout'></i>
                            </a> 
                            <div class="nombre-rol">
                                <div class="nombre_perfil"><?php echo s($_SESSION['nombre']) ?? '?' ?></div>
                                <div class="rol"><?php echo s($_SESSION['rol']) ?? ''  ?></div>
                            </div>
                                
                        </div>
                    </li>
                </ul>
        </div>

    <?php echo $contenido; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    
    <script src="https://kit.fontawesome.com/b0f76a427d.js" crossorigin="anonymous"></script>

    <!-- EXPORTAR EXCEL -->
    <script src="https://unpkg.com/xlsx@0.16.9/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
    <script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
    
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->

    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>



    <script src="https://cdn.datatables.net/responsive/3.0.1/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.1/js/responsive.dataTables.js"></script>




    <script src="../build/js/app.js"></script>
    <script src="../build/js/select2.js"></script>
    <script src="../build/js/clienteNuevo.js"></script> 
    <script src="../build/js/VendedorNuevo.js"></script> 
    <script src="../build/js/guias.js"></script>
    <script src="../build/js/buscar.js"></script>
    <script src="../build/js/tablas.js"></script>

    </body>
</html>