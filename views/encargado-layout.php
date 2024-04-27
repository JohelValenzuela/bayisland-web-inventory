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
        <!-- <link href="../build/css/vanilla-dataTables.css" rel="stylesheet" type="text/css"> -->
        <!-- <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.0.1/b-3.0.0/b-html5-3.0.0/b-print-3.0.0/datatables.min.css" rel="stylesheet"> -->
        <!-- <link href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css" rel="stylesheet"> -->
        <script src="https://kit.fontawesome.com/b0f76a427d.js" crossorigin="anonymous"></script>
        <!-- <script src="https://unpkg.com/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script> -->
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
                    <div class="name-job">
                        <div class="nombre_perfil"><?php echo s($_SESSION['nombre']) ?? '?' ?></div>
                        <div class="job"><?php echo s($_SESSION['rol']) ?? ''  ?></div>
                    </div>
                    <a href="/auth/logout">
                        <i class='bx bx-log-out logout'></i>
                    </a>
                    
                    </div>
                </li>
            </ul>
        </div>

    <?php echo $contenido; ?>

    <script src="../build/js/app.js"></script>

    </body>
</html>