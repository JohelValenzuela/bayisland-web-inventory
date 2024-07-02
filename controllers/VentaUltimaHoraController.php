<?php

namespace Controllers;

use MVC\Router;
use Model\VentaUltimaHora;
use Model\Vendedor;
use Model\Cobrador;

class VentaUltimaHoraController {

    public static function mostrar(Router $router) {

        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        
        $alertas = [];

        $venta = VentaUltimaHora::all();

        $alertas = VentaUltimaHora::getAlertas();

        $router->render('ventas_ultima_hora/mostrar', [
            'venta' => $venta,
            'alertas' => $alertas
        ]);
    }

    public static function crear(Router $router) {
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        
        $venta = new VentaUltimaHora;
        $alertas = [];

        date_default_timezone_set('America/Costa_Rica');
        $fechaActual = date(format:'Y-m-d H:i:s');
        $venta->fecha = $fechaActual;
       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $venta->sincronizar($_POST);
            $alertas = $venta->validar();

            if (empty($alertas)) {
                $resultado = $venta->guardar();
                if ($resultado) {
                    VentaUltimaHora::setAlerta('exito', 'Venta creada al cliente ' . $venta->nombre_persona);
                }
            }
        }

        $alertas = VentaUltimaHora::getAlertas();

        $router->render('ventas_ultima_hora/crear', [
            'venta' => $venta,
            'alertas' => $alertas
        ]);
    }
}
