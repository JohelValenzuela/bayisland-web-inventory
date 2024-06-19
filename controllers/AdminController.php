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

    public static function pdfGestionaPasajero(Router $router){
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        $router->render('fpdf/pdfGestionaPasajero', []);
    }

    public static function pdfPasajeros(Router $router){
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        $router->render('fpdf/pdfPasajeros', []);
    }

    public static function pdfDefectos(Router $router){
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        $router->render('fpdf/pdfDefectos', []);
    }

    public static function pdfRegalias(Router $router){
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        $router->render('fpdf/pdfRegalias', []);
    }

    public static function pdfVentasUltimaHora(Router $router){
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        $router->render('fpdf/pdfVentasUltimaHora', []);
    }

    public static function pdfRecetas(Router $router){
        isAuth();
        if(!tieneRol()) {
            header('Location: /templates/error403');
        }
        $router->render('fpdf/pdfRecetas', []);
    }


    
}