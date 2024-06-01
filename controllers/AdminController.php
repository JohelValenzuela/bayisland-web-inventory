<?php

namespace Controllers;
use MVC\Router;

class AdminController {


    public static function admin(Router $router){
        $router->render('admin/admin', []);
    }

    public static function csvProducto(Router $router){
        $router->render('producto/csvProducto', []);
    }
    

    public static function pdfCategoria(Router $router){
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        $router->render('fpdf/pdfCategoria', []);
    }

    public static function pdfProducto(Router $router){
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        $router->render('fpdf/pdfProducto', []);
    }

    public static function pdfStock(Router $router){
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        $router->render('fpdf/pdfStock', []);
    }

    public static function pdfUsuario(Router $router){
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        $router->render('fpdf/pdfUsuario', []);
    }

    public static function pdfPedido(Router $router){
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        $router->render('fpdf/pdfPedido', []);
    }

    public static function pdfInventario(Router $router){
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        $router->render('fpdf/pdfInventario', []);
    }

    public static function pdfMedidas(Router $router){
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        $router->render('fpdf/pdfMedidas', []);
    }


    
}