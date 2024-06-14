<?php

namespace Controllers;

use Model\Capitan;
use Model\Guia;
use Model\ReportePasajero;
use MVC\Router;

class ReportePasajeroController {

    public static function mostrar(Router $router) {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $capitanes = Capitan::all();
        $guias = Guia::all();
        $reportes = ReportePasajero::all();
       
        foreach ($reportes as $reporte) {
            $reporte->reportado_por = Guia::find($reporte->reportado_por_id);
        }

        
        $router->render('pasajeros/mostrar', [
            'capitanes' => $capitanes,
            'guias' => $guias,
            'reportes' => $reportes
        ]);
    }


    public static function crear(Router $router) {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $alertas = [];

        $capitanes = Capitan::all();
        $guias = Guia::all();
        
    
        // Manejar el POST para crear un nuevo reporte
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Array para almacenar los IDs de las guías
            $guias_data = [];
            $maxGuias = 5;
            
            // Procesar los datos de las guías dinámicamente
            for ($i = 1; $i <= $maxGuias; $i++) {
                $nombre = $_POST['guia' . $i . '_nombre'] ?? null;

                // Verificar si el nombre está vacío y establecer el ID y pasajeros a NULL
                if (empty($nombre)) {
                    $guias_data['guia' . $i . '_id'] = null;
                    $guias_data['guia' . $i . '_pasajeros'] = 0;
                }

                if ($nombre) {
                    // Crear una nueva instancia de Guia y guardarla en la base de datos
                    $guia = new Guia(['nombre' => $nombre]);
                    $resultado = $guia->guardar();
                
                    // Agregar el ID de la guía al array
                    $guias_data['guia' . $i . '_id'] = $resultado['id'] ?? null;
                    $guias_data['guia' . $i . '_pasajeros'] = $_POST['guia' . $i . '_pasajeros'] ?? 0;
                } else {
                    // Agregar el ID de la guía al array
                    $guias_data['guia' . $i . '_id'] = $_POST['guia' . $i . '_id'] ?? null;
                    $guias_data['guia' . $i . '_pasajeros'] = $_POST['guia' . $i . '_pasajeros'] ?? 0;
                }
            }
            
            $guia_muelle = $_POST['guia_nombre_muelle'] ?? null;

            if ($guia_muelle) {
                // Crear una nueva instancia de Guia y guardarla en la base de datos
                $guia_muelle = new Guia(['nombre' => $guia_muelle]);
                $resultado = $guia_muelle->guardar();
                // Almacenar el guia y pasajeros
                $guias_muelle = $resultado['id'] ?? null;
                $pasajeros_muelle = $_POST['pasajeros_muelle'] ?? 0;
            } else {
                // Almacenar el guia y pasajeros
                $guias_muelle = $_POST['guia_muelle'] ?? null;
                $pasajeros_muelle = $_POST['pasajeros_muelle'] ?? 0;
            }


            $nombre_reporta = $_POST['reportado_por_nombre'] ?? null;
            
            if ($nombre_reporta) {
                // Crear una nueva instancia de Guia y guardarla en la base de datos
                $nombre_reporta = new Guia(['nombre' => $nombre_reporta]);
                $resultado = $nombre_reporta->guardar();
                // Almacenar el id
                $reporta_id = $resultado['id'] ?? null;
            } else {
                // Almacenar el id
                $reporta_id = $_POST['reportado_por_id'] ?? null;
            }

            

            $nombre_capitan = $_POST['capitan_nombre'] ?? null;
            
            if ($nombre_capitan) {
                // Crear una nueva instancia de Guia y guardarla en la base de datos
                $nombre_capitan = new Capitan(['nombre' => $nombre_capitan]);
                $resultado = $nombre_capitan->guardar();
                // Almacenar el id
                $capitan_id = $resultado['id'] ?? null;
            } else {
                // Almacenar el id
                $capitan_id = $_POST['capitan_id'] ?? null;
            }
      
            
            // Crear un nuevo reporte con los datos recibidos
            $reporte_data = [
                // Agregar los demás datos del formulario al reporte
                'guia_muelle_id' => $guias_muelle ?? 0,
                'pasajeros_muelle' => $pasajeros_muelle ?? 0,
                'pasajeros_no_show' => $_POST['pasajeros_no_show'] ?? 0,
                'reportado_por_id' => $reporta_id ?? null,
                'guias_bote_ids' => isset($_POST['guias_bote_ids']) ? implode(',', $_POST['guias_bote_ids']) : '',
                'capitan_id' => $capitan_id ?? null,
            ];
            // Fusionar los datos de las guías con los datos del reporte
            $reporte_data = array_merge($guias_data, $reporte_data);
            
            // Crear instancia de ReportePasajero
            $reporte = new ReportePasajero($reporte_data);
            
            date_default_timezone_set('America/Costa_Rica');
            $reporte->fecha = date('Y-m-d H:i:s');
            
            // Validar y guardar el reporte
            $alertas = $reporte->validar();

            //debug($reporte);
            
            if (empty($alertas)) {
                // Guardar datos del reporte en la base de datos
                $resultado = $reporte->crearReportePasajero();

                if($resultado){
                    
                    ReportePasajero::setAlerta('exito', 'Se ha creado un nuevo reporte de pasajeros');
                    $_SESSION['msg'] = ReportePasajero::getAlertas();
                    
                }

                //Redirigir después de guardar los datos
                header('Location: /pasajeros/crear');
                exit;
            }
        }

        $alertas = ReportePasajero::getAlertas();
    
        if (isset($_SESSION['msg'])) {
            $alertas = $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        $router->render('pasajeros/crear', [
            'alertas' => $alertas,
            'capitanes' => $capitanes,
            'guias' => $guias,
        ]);
    }

    public static function gestionaReporte(Router $router){

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $alertas = [];

        $id = validarORedireccionar('/pasajeros'); 
        $reporte = ReportePasajero::find($id);



        $capitanes = Capitan::all();
        $guias = Guia::all();
       
            $reporte->guia1 = ($reporte->guia1_id == NULL) ? '' : Guia::find($reporte->guia1_id);
            $reporte->guia2 = ($reporte->guia2_id == NULL) ? '' : Guia::find($reporte->guia2_id);
            $reporte->guia3 = ($reporte->guia3_id == NULL) ? '' : Guia::find($reporte->guia3_id);
            $reporte->guia4 = ($reporte->guia4_id == NULL) ? '' : Guia::find($reporte->guia4_id);
            $reporte->guia5 = ($reporte->guia5_id == NULL) ? '' : Guia::find($reporte->guia5_id);
            $reporte->guia_muelle = ($reporte->guia_muelle_id == NULL) ? '' : Guia::find($reporte->guia_muelle_id);
            $reporte->reportado_por = ($reporte->reportado_por_id == NULL) ? '' : Guia::find($reporte->reportado_por_id);
            $reporte->capitan = ($reporte->capitan_id == NULL) ? '' : Capitan::find($reporte->capitan_id);
        


        $alertas = ReportePasajero::getAlertas();

        $router->render('pasajeros/gestionaReporte', [
            'alertas' => $alertas,
            'reporte' => $reporte,
        ]);

    }

    public static function generarReportePDF(Router $router){

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $alertas = [];

        

        $alertas = ReportePasajero::getAlertas();

        $router->render('fpdf/generarReportePDF', [
            'alertas' => $alertas,
        ]);

    }

}
