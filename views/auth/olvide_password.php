<section class="container forms">
    <div class="form login">
        <div class="form-contenedor">
            <header>Olvidé mi Contraseña</header>

        <?php 
            include_once __DIR__ . "/../templates/alertas.php";
        ?>

                <form  class="form-campo" action="/auth/olvide_password" method="POST">
                    <div class="campo campo-unido">
                        <input id="correo" name="correo" type="email" placeholder="Correo Electrónico" class="formulario-input">
                    </div>

                    <div class="campo campo-unido">
                        <button class="boton-exportar login" style="width: 100%;">Recuperar Contraseña</button>
                    </div>
                </form>

                <div class="form-enlace">
                <span>¿Quieres regresar? <a href="/" class="link login-link">Inicia Sesión</a></span>
            </div>
            </div>
        </div>
    </div>
</section>