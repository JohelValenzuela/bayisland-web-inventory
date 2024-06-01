<?php

namespace Controllers;
use MVC\Router;

class Errores {

    public static function error403(Router $router){
        $router->render('templates/error403', []);
    }

    public static function error404(Router $router){
        $router->render('templates/error404', []);
    }

    
        
}