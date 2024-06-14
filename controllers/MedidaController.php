<?php

namespace Controllers;

use Classes\Paginacion;
use Model\UnidadMedida;
use MVC\Router;

class MedidaController {

    public static function mostrar(Router $router){

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $medidas = UnidadMedida::all();
        if(!empty($medidas)){


            $router->render('medida/mostrar', [
                'medidas' => $medidas
            ]);
        } else {
            $router->render('medida/mostrar', []);
        }    
    }

    public static function crear(Router $router){

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $medidas = new UnidadMedida;
        
        $medidas->estado = "Activo";

        // Alertas 
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $medidas->sincronizar($_POST);
            $alertas = $medidas->validar();
            
            // REVISA QUE EL ARRAY DE ERRORES ESTE VACIO
            if(empty($alertas)){

            // Verifica que la medida no exista
            $resultado = $medidas->existeMedida();

                if($resultado ->num_rows) {
                    $alertas = UnidadMedida::getAlertas();
                } else {
                    // Se llama la funcion para guardar en la DB
                    $resultado = $medidas->crear();

                    if($resultado) { // Si se guarda el usuario envia una alerta
                        //header('Location: /categoria');
                        UnidadMedida::setAlerta('exito', 'Se ha creado una nueva medida');
                    }
                }    
            }
        }      

        $alertas = UnidadMedida::getAlertas();
        $router->render('medida/crear', [
            'medidas' => $medidas,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router){
        
        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $id = validarORedireccionar('/categoria');   
        $medidas = UnidadMedida::find($id);

        // Alertas 
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $medidas->sincronizar($_POST);
            $alertas = $medidas->validar();
            
            // REVISA QUE EL ARRAY DE ERRORES ESTE VACIO
            if(empty($alertas)){
                
                // Se llama la funcion para guardar en la DB
                $resultado = $medidas->guardar();
                
                if($resultado) { // Si se guarda el usuario envia una alerta
                    //header('Location: /categoria');
                    UnidadMedida::setAlerta('exito', 'Se ha actualizado la unidad de medida');
                }
            }
        }      

        $alertas = UnidadMedida::getAlertas();
        $router->render('medida/actualizar', [
            'medidas' => $medidas,
            'alertas' => $alertas
        ]);
    }
        
}