<section class="home-section">
    <div class="flex-carrito">
        <div class="home-content">
            <i class='bx bx-menu' ></i>
            <span class="text">Detalles de Usuario Temporal</span>
        </div>
        <div class="home-carrito">
            <a href="/auth/mostrarTemporal" class="boton-exportar volver"> Regresar  <i class="fa-solid fa-person-walking-arrow-loop-left"></i> </a>
        </div>
            
    </div>

    <form action="generarReportePDF" class="form form-contenido form-flex" method="POST" value="Crear" enctype="multipart/form-data">
    
        <?php use Model\Auth;

        // Verificar si hay un ID en la consulta
        if (!isset($_GET['id'])) {
            header('Location: /auth/crear_cuentaTemporal'); // Redirige si no hay ID
            exit();
        }

        $id = (int) $_GET['id'];
        $usuario = Auth::find($id); // Método find() para obtener detalles del usuario

        if (!$usuario) {
            header('Location: /auth/crear_cuentaTemporal'); // Redirige si no se encuentra el usuario
            exit();
        }

        ?>

        <div style="width: inherit;">
            <h2 style="margin-bottom: 5rem;">Detalles del Usuario</h2>
            <?php if ($usuario->tipo_usuario === 'temporal'): ?>
                <div class="contenedor-flex">
                    <div class="contenido-flex">
                        <!-- <p><strong>ID:</strong> <?php echo htmlspecialchars($usuario->id); ?></p> -->
                        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario->nombre) . " " . htmlspecialchars($usuario->apellido); ?></p>
                        <p><strong>Usuario:</strong> <?php echo htmlspecialchars($usuario->username); ?></p>

                        <?php if (isset($_SESSION['nueva_password'])) : ?>
                                <p><strong>Contraseña:</strong> <?php echo $_SESSION['nueva_password'];  ?><strong style="font-size: 1.6rem; color: red;">* No se mostrará más cuando dejes esta página</strong></p>
                            <?php unset($_SESSION['nueva_password']); // Limpiar la sesión ?>
                        <?php endif; ?>
                    
                    </div>
                    <div class="contenido-flex">
                    
                    <p><strong>Tipo de Usuario:</strong> <?php echo htmlspecialchars($usuario->tipo_usuario); ?></p>
                    <p><strong>Rol:</strong> <?php echo htmlspecialchars($usuario->rolId); ?></p>
                    <p><strong>Estado:</strong> <?php echo htmlspecialchars($usuario->estado); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </form> 

</section>   




