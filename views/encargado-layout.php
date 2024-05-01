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
                    <a href="#">
                    <i class='bx bx-cog' ></i>
                    <span class="enlace-texto">Ajustes</span>
                    </a>
                    <ul class="sub-menu blank">
                    <li><a class="enlace-texto" href="#">Ajustes</a></li>
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