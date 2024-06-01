<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Categoria;
use Model\Producto;
use Model\Receta;
use Model\UnidadMedida;
use MVC\Router;

class ProductoController {

    public static function mostrar(Router $router) {
        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $producto = Producto::all();
        if(!empty($producto)){

            
            $producto=Producto::all();
            $categoria = Categoria::all();
            $medidas = UnidadMedida::all();

            foreach ($producto as $productos) {
                $productos->categoria = Categoria::find($productos->categoriaId);
                $productos->medida = UnidadMedida::find($productos->medidaId);
            }

            // muestra mensaje condicional
            $resultado = $_GET['resultado'] ?? null; //le asigna el valor null en caso de que no esté resultado

            

            $router->render('producto/mostrar', [
                'producto' => $producto,
                'categoria' => $categoria,
                'medidas' => $medidas,
                'resultado' => $resultado
            ]);
        } else {
            $router->render('producto/mostrar', []);
        }
    }

    public static function crear(Router $router) {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $producto = new Producto;
        $medidas = UnidadMedida::all();
        $categoria = Categoria::all();

        

        $producto->estado = "1";

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $producto->sincronizar($_POST);
            $alertas = $producto->validar();


            $totalMedida = $producto->totalMedida; // Cantidad de Medida (Onza)
            $precioMedida = $producto->precioMedida; // Precio por Medida (Onza)
            $precioUnidad = $producto->precioUnidad; // Precio por Producto
            $subtotal = $totalMedida * $precioMedida; // Subtotal
            $total = $subtotal + $precioUnidad;

            $producto->total = $total;
                   
            // REVISA QUE EL ARRAY DE ERRORES ESTE VACIO
            if(empty($alertas)){
                
                // Se llama la funcion para guardar en la DB
                $resultado = $producto->guardar();
                
                if($resultado) { // Si se guarda el usuario envia una alerta
                    Producto::setAlerta('exito', 'Se ha creado un nuevo producto');
                    //header('Location: /producto');
                }
            }
        }

        $alertas = Producto::getAlertas();
        $router->render('producto/crear', [
            'producto' => $producto,
            'medidas' => $medidas,
            'categoria' => $categoria,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router) {

        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $categoria = Categoria::all();
        $medidas = UnidadMedida::all();


        $id = validarORedireccionar('/producto'); 
        $producto = Producto::find($id);
        

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $producto->sincronizar($_POST);
            
            $alertas = $producto->validar();

            $totalMedida = $producto->totalMedida; // Cantidad de Medida (Onza)
            $precioMedida = $producto->precioMedida; // Precio por Medida (Onza)
            $precioUnidad = $producto->precioUnidad; // Precio por Producto
            $subtotal = $totalMedida * $precioMedida; // Subtotal
            $total = $subtotal + $precioUnidad;

            $producto->total = $total;
            
                   
            // REVISA QUE EL ARRAY DE ERRORES ESTE VACIO
            if(empty($alertas)){
                
                // Se llama la funcion para guardar en la DB
                $resultado = $producto->guardar();
                
                if($resultado) { // Si se guarda el usuario envia una alerta
                    Producto::setAlerta('exito', 'Se ha actualizado el producto');
                    //header('Location: /producto');
                }
            }
        }
        $alertas = Producto::getAlertas();
        $router->render('producto/actualizar', [
            'categoria' => $categoria,
            'medidas' => $medidas,
            'producto' => $producto,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar(){
        
        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        if($_SESSION['rol'] === 'Administrador') {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'];
                $categoria = Producto::find($id);
                $categoria->eliminar();
                header('Location: /producto');
            }
        } else {
            header('Location: /templates/error403');
        }
        
        
    }


}