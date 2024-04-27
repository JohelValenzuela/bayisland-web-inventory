<section class="container forms">
    <div class="form login">
        <div class="form-contenedor">
            <header>Reestablecer Contraseña</header>

        <?php 
            include_once __DIR__ . "/../templates/alertas.php";
        ?>

        <?php
            if($error) return;
        ?>

                <div class="form-enlace">
                  <span>Ingresa tu nueva contraseña a continuación</span>
                </div>

                <form  class="form-campo" method="POST">

                    <div class="campo campo-unido">
                        <input id="password" name="password" type="password" placeholder="Nueva Contraseña" class="password">
                    </div>

                    <div class="campo campo-unido">
                        <button class="boton boton-naranja">Reestablecer Contraseña</button>
                    </div>
                </form>

                <div class="form-enlace">
                    <span>¿Quieres regresar? <a href="/" class="link login-link">Inicia Sesión</a></span>
                </div>
            </div>
        </div>
    </div>
</section>