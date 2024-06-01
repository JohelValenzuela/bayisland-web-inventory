<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Categoria;
use MVC\Router;

class CategoriaController {

    public static function mostrar(Router $router) {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $categoria = Categoria::all();
        if(!empty($categoria)){

        $categoria = Categoria::all();

            // muestra mensaje condicional
            $resultado = $_GET['resultado'] ?? null; //le asigna el valor null en caso de que no esté resultado
            
            $router->render('categoria/mostrar', [
                'categoria' => $categoria,
                'resultado' => $resultado
            ]);
        } else {
            $router->render('categoria/mostrar', []);
        }
    }

    public static function crear(Router $router) {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $categoria = new Categoria;
        
        $categoria->estado = "Activo";

        // Alertas 
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $categoria->sincronizar($_POST);
            $alertas = $categoria->validar();
                   
            // REVISA QUE EL ARRAY DE ERRORES ESTE VACIO
            if(empty($alertas)){

                // Verifica que la categoria no exista
                $resultado = $categoria->existeCategoria();

                if($resultado ->num_rows) {
                    $alertas = Categoria::getAlertas();
                } else {
                    // Se llama la funcion para guardar en la DB
                    $resultado = $categoria->guardar();
                        
                    if($resultado) { // Si se guarda el usuario envia una alerta
                        //header('Location: /categoria');
                        Categoria::setAlerta('exito', 'Se ha creado una nueva categoría');
                    }        
                }  
            }
        }      


        $alertas = Categoria::getAlertas();
        $router->render('categoria/crear', [
            'categoria' => $categoria,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router) {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }
        
        $id = validarORedireccionar('/categoria');   
        $categoria = Categoria::find($id);

        // Alertas 
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $categoria->sincronizar($_POST);
            
            $alertas = $categoria->validar();

            // Revisa que alertas esté vacio
            if(empty($alertas)) {
                
                // Guarda Categoría
                $resultado = $categoria->guardar();

                if($resultado) { // Si se guarda el usuario envia una alerta                       
                    Categoria::setAlerta('exito', 'Se ha actualizado la categoría');                      
                    //header('Location: /categoria');
                }
            }
        }

        $alertas = Categoria::getAlertas();
        $router->render('categoria/actualizar', [
            'categoria' => $categoria,
            'alertas' => $alertas
        ]);
    }

     public static function desactivar() {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }
        
      if($_SERVER['REQUEST_METHOD'] === 'POST') {
          $id = $_POST['id'];
          $categoria = Categoria::find($id);
          $categoria->estado = "Inactivo";
          $categoria->guardar();
          
          header('Location: /categoria');
      }


    }
}










