<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistema de Inventario Web</title>
        <link rel="shortcut icon" href="/build/img/logo.png" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="../build/css/app.css">
        <link rel="stylesheet" href="../build/css/datatables.css">
        <link rel="stylesheet" href="../build/css/select.css">
        <link rel="stylesheet" href="../build/css/responsive.css">
    </head>

    <body>
        <div class="sidebar close">
            <div class="logo-detalle">
                <i class='bx bxs-ship'></i>
            </div>

                <ul class="enlace-navegacion">
                <li>
                    <a href="/dashboard">
                        <i class='bx bx-grid-alt' ></i>
                        <span class="enlace-texto">Dashboard</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="enlace-texto" href="/dashboard">Dashboard</a></li>
                    </ul>
                </li>
                <li>
                    <div class="enlace-link enlace">
                        <a href="/categoria">
                            <i class='bx bx-collection'></i>
                            <span class="enlace-texto">Categoría</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow' ></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="enlace-texto" href="/categoria">Categoría</a></li>
                        <li><a href="/categoria/crear">Nueva Categoría</a></li>
                        <li><a href="/categoria">Mostrar Categorías</a></li>
                        <li><a href="/fpdf/pdfCategoria">Generar PDF Categoría</a></li>
                        <li><a href="#">Imprimir Categoría</a></li>
                    </ul>
                </li>

                
                <li>
                    <div class="enlace-link">
                        <a href="/producto">
                            <i class='bx bx-package' ></i>
                            <span class="enlace-texto">Producto</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow' ></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="enlace-texto" href="/producto">Producto</a></li>
                        <li><a href="/producto/crear">Nueva Producto</a></li>
                        <li><a href="/producto">Mostrar Productos</a></li>
                        <li><a href="/fpdf/pdfProducto">Generar PDF Producto</a></li>
                        <li><a href="#">Imprimir Producto</a></li>
                    </ul>
                </li>

                <li>
                    <div class="enlace-link">
                        <a href="/pedido">
                            <i class='bx bx-cart'></i>
                            <span class="enlace-texto">Pedido</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow' ></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="enlace-texto" href="#">Pedido</a></li>
                        <li><a href="#">Nuevo Pedido</a></li>
                        <li><a href="#">Mostrar Pedidos</a></li>
                        <li><a href="#">Pedidos Aceptados</a></li>
                        <li><a href="#">Pedidos Rechazados</a></li>
                        <li><a href="#">Generar PDF Pedidos</a></li>
                        <li><a href="#">Generar PDF Pedidos Aceptados</a></li>
                        <li><a href="#">Generar PDF Pedidos Rechazados</a></li>
                    </ul>
                </li>

                <li>
                    <div class="enlace-link">
                        <a href="/stock">
                            <i class='bx bx-box' ></i>
                            <span class="enlace-texto">Stock</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow' ></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="enlace-texto" href="#">Stock</a></li>
                        <li><a href="/inventario">Mostrar Stock</a></li>
                        <li><a href="/inventario/entrada">Entrada de Stock</a></li>
                        <li><a href="/inventario/salida">Salida de Stock</a></li>
                        <li><a href="/fpdf/pdfInventario">Generar PDF Stock</a></li>
                    </ul>
                </li>

                <li>
                    <div class="enlace-link">
                        <a href="/inventario">
                            <i class='bx bx-history'></i><!-- <i class='bx bx-book-alt'></i> -->
                            <span class="enlace-texto">Kardex</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow' ></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="enlace-texto" href="#">Kardex</a></li>
                        <li><a href="/inventario">Mostrar Kardex</a></li>
                        <li><a href="/fpdf/pdfInventario">Generar PDF Kardex</a></li>
                    </ul>
                </li>

                <li>
                    <div class="enlace-link">
                        <a href="/auth/mostrar">
                            <i class='bx bx-user' ></i>
                            <span class="enlace-texto">Usuarios</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow' ></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="enlace-texto" href="/auth/mostrar">Usuarios</a></li>
                        <li><a href="/auth/crear_cuenta">Nuevo Usuario</a></li>
                        <li><a href="/auth/mostrar">Mostrar Usuarios</a></li>
                        <li><a href="/fpdf/pdfUsuario">Generar PDF Usuarios</a></li>
                    </ul>
                </li>

                <li>
                    <div class="enlace-link">
                        <a href="/medida">
                            <i class='bx bx-ruler'></i>
                            <span class="enlace-texto">Medidas</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow' ></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="enlace-texto" href="/medida">Unidades de Medida</a></li>
                        <li><a href="/medida">Mostrar Medidas</a></li>
                        <li><a href="/medida/crear">Crear Medidas</a></li>
                        <li><a href="/fpdf/pdfUsuario">Generar PDF Medidas</a></li>
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
    
    <script src="https://kit.fontawesome.com/b0f76a427d.js" crossorigin="anonymous"></script>

    <!-- EXPORTAR EXCEL -->
    <script src="https://unpkg.com/xlsx@0.16.9/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
    <script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>



    <script src="https://cdn.datatables.net/responsive/3.0.1/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.1/js/responsive.dataTables.js"></script>



    <script src="../build/js/app.js"></script>
    <script src="../build/js/buscar.js"></script>
    <script src="../build/js/tablas.js"></script>

    </body>
</html>