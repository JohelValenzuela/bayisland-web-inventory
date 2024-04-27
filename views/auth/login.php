<section class="container forms">
    <div class="form login">
        <div class="form-contenedor">
            <img class="logo-login" src="/build/img/logo.webp" alt="logo-login">

        <?php 
            include_once __DIR__ . "/../templates/alertas.php";
        ?>

                <form class="form-campo" action="/auth/login" method="POST">
                    <div class="campo campo-unido">
                        <input id="correo" name="correo" type="email" placeholder="Correo Electrónico" class="input login-input">
                    </div>

                    <div class="campo campo-unido">
                        <input id="password" name="password" type="password" placeholder="Contraseña" class="password login-input">
                    </div>

                    <div class="campo button-field">
                        <input type="submit" class="boton boton-azul margin" value="Ingresar">
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>