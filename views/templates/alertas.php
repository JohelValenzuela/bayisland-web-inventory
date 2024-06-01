<?php foreach ($alertas as $key => $mensajes) : ?>
    <section class="form form-contenido form-alerta">
        <?php foreach ($mensajes as $mensajes) : ?>
            <div class="alerta <?php echo $key; ?>">
                <?php echo $mensajes; ?>
            </div>
        <?php endforeach; ?>
    </section>
<?php endforeach; ?>

    
