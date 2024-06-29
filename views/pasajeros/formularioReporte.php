<?php
    // Convertir la fecha de creación al formato dd-mm-yyyy
    $fechaCreacion = new DateTime($reporte->fecha);
    $fecha = $fechaCreacion->format('d-m-Y');
    $fechaCreacionFormateada = $fechaCreacion->format('d-m-Y H:i:s');

    $cantidad_pasajeros = $reporte->guia1_pasajeros + $reporte->guia2_pasajeros + $reporte->guia3_pasajeros + $reporte->guia4_pasajeros + $reporte->guia5_pasajeros + $reporte->pasajeros_muelle;
?>
    
<div style="width: inherit;">
    <h2 style="margin-bottom: 5rem;">Reporte de Pasajeros (<?php echo $fecha ?>)</h2>

<div class="contenedor-flex">
    <div class="contenido-flex">
        <p><strong>Nº Reporte:</strong> <?php echo $reporte->id; ?></p>
        <p><strong>Fecha:</strong> <?php echo $fechaCreacionFormateada; ?></p>
        <p><strong>Reporta:</strong> <?php echo ($reporte->reportado_por) ? $reporte->reportado_por->nombre : 'Sin Guía'; ?></p>
        <p><strong>Capitán a Bordo:</strong> <?php echo ($reporte->capitan) ? $reporte->capitan->nombre : 'Sin Capitán'; ?></p>
        <p><strong>Cantidad de Pasajeros:</strong> <?php echo $cantidad_pasajeros . ' pasajeros';?></p>
        <p><strong>Cantidad de Guías:</strong> <?php echo count(explode(',',$reporte->guias_bote_ids)) . ' Guías';?></p>
    </div>
    <div class="contenido-flex">
        <?php if ($reporte->guia1_id != NULL && $reporte->guia1_pasajeros > 0) : ?>
            <p style="color: black;"><strong>Guía 1:</strong> <?php echo ($reporte->guia1_id) ? $reporte->guia1->nombre . ' - ' . $reporte->guia1_pasajeros . ' pasajeros' : 'Sin Guía - 0 pasajeros'; ?></p>
        <?php endif?>

        <?php if ($reporte->guia2_id != NULL && $reporte->guia2_pasajeros > 0) : ?>
            <p style="color: black;"><strong>Guía 2:</strong> <?php echo ($reporte->guia2_id) ? $reporte->guia2->nombre . ' - ' . $reporte->guia2_pasajeros . ' pasajeros' : 'Sin Guía - 0 pasajeros'; ?></p>
        <?php endif?>

        <?php if ($reporte->guia3_id != NULL && $reporte->guia3_pasajeros > 0) : ?>
            <p style="color: black;"><strong>Guía 3:</strong> <?php echo ($reporte->guia3_id) ? $reporte->guia3->nombre . ' - ' . $reporte->guia3_pasajeros . ' pasajeros' : 'Sin Guía - 0 pasajeros'; ?></p>
        <?php endif?>

        <?php if ($reporte->guia4_id != NULL && $reporte->guia4_pasajeros > 0) : ?>
            <p style="color: black;"><strong>Guía 4:</strong> <?php echo ($reporte->guia4_id) ? $reporte->guia4->nombre . ' - ' . $reporte->guia4_pasajeros . ' pasajeros' : 'Sin Guía - 0 pasajeros'; ?></p>
        <?php endif?>

        <?php if ($reporte->guia5_id != NULL && $reporte->guia5_pasajeros > 0) : ?>
            <p style="color: black;"><strong>Guía 5:</strong> <?php echo ($reporte->guia5_id) ? $reporte->guia5->nombre . ' - ' . $reporte->guia5_pasajeros . ' pasajeros' : 'Sin Guía - 0 pasajeros'; ?></p>
        <?php endif?>

        <?php if ($reporte->guia_muelle != NULL && $reporte->pasajeros_muelle > 0) : ?>
            <p style="color: black;"><strong>Guía Muelle:</strong> <?php echo ($reporte->guia_muelle) ? $reporte->guia_muelle->nombre . ' - ' . $reporte->pasajeros_muelle . ' pasajeros' : 'Sin Guía - 0 pasajeros'; ?></p>
        <?php endif?>
        
        <?php if ($reporte->pasajeros_no_show > 0) : ?>
            <p style="color: black;"><strong>NoShow:</strong> <?php echo $reporte->pasajeros_no_show . ' pasajeros'; ?></p>
        <?php endif?>
        
        <!-- <table class="tabla" id="">
            <thead>
                <?php if(!empty($reporte)) { ?>
                    <!-- <tr>
                        <th>ID</th> 
                        <td><?php echo $reporte->id; ?></td>
                    </tr>
                    <tr>
                        <th>Fecha</th> 
                        <td><?php echo $fechaCreacionFormateada; ?></td>
                    </tr> -->
                    <tr>
                        <th>Guía 1</th> 
                        <td><?php echo ($reporte->guia1_id) ? $reporte->guia1->nombre . ' - ' . $reporte->guia1_pasajeros . ' pasajeros' : 'Sin Guía - 0 pasajeros'; ?></td>
                    </tr>
                    <tr>
                        <th>Guía 2</th> 
                        <td><?php echo ($reporte->guia2_id) ? $reporte->guia2->nombre . ' - ' . $reporte->guia2_pasajeros . ' pasajeros' : 'Sin Guía - 0 pasajeros'; ?></td>
                    </tr>
                    <tr>
                        <th>Guía 3</th> 
                        <td><?php echo ($reporte->guia3_id) ? $reporte->guia3->nombre . ' - ' . $reporte->guia3_pasajeros . ' pasajeros' : 'Sin Guía - 0 pasajeros'; ?></td>
                    </tr>
                    <tr>
                        <th>Guía 4</th> 
                        <td><?php echo ($reporte->guia4_id) ? $reporte->guia4->nombre . ' - ' . $reporte->guia4_pasajeros . ' pasajeros' : 'Sin Guía - 0 pasajeros'; ?></td>
                    </tr>
                    <tr>
                        <th>Guía 5</th> 
                        <td><?php echo ($reporte->guia5_id) ? $reporte->guia5->nombre . ' - ' . $reporte->guia5_pasajeros . ' pasajeros' : 'Sin Guía - 0 pasajeros'; ?></td>
                    </tr>
                    <tr>
                        <th>Guía Muelle</th> 
                        <td><?php echo ($reporte->guia_muelle) ? $reporte->guia_muelle->nombre . ' - ' . $reporte->pasajeros_muelle . ' pasajeros' : 'Sin Guía - 0 pasajeros'; ?></td>
                    </tr>
                    <tr>
                        <th>NoShow</th> 
                        <td><?php echo $reporte->pasajeros_no_show . ' pasajeros'; ?></td>
                    </tr>
                    <!-- <tr>
                        <th>Reporta</th> 
                        <td><?php echo ($reporte->reportado_por) ? $reporte->reportado_por->nombre : 'Sin Guía'; ?></td>
                    </tr>
                    <tr>
                        <th>Cantidad Pasajeros</th> 
                        <td><?php echo $cantidad_pasajeros . ' pasajeros'; ?></td>
                    </tr>
                    <tr>
                        <th>Capitán Bote</th> 
                        <td><?php echo ($reporte->capitan) ? $reporte->capitan->nombre : 'Sin Capitán'; ?></td>
                    </tr> -->
                <?php } ?> 
            </thead>
        </table>   -->
    </div>
</div>
     
</div>