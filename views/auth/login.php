<section class="container forms">
    <div class="form login">
        <div class="form-contenedor">
            <img class="logo-login" src="/build/img/logo.webp" alt="logo-login">

        <?php 
            include_once __DIR__ . "/../templates/alertas.php";
        ?>

                <form class="form-campo" action="/auth/login" method="POST">
                    <div class="campo campo-unido">
                        <input id="correo" name="correo" type="email" placeholder="Correo Electrónico" class="formulario-input">
                    </div>

                    <div class="campo campo-unido">
                        <input id="password" name="password" type="password" placeholder="Contraseña" class="formulario-input">
                    </div>

                    <div class="form-enlace">
                        <a href="/auth/olvide_password" class="forgot-pass"><span>¿Olvidaste la contraseña?</span></a>
                    </div>

                    <div class="campo button-field">
                        <input type="submit" class="boton-exportar login " value="Ingresar">
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>