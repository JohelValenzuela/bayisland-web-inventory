<?php

namespace Controllers;

use Model\Auth;
use Model\Categoria;
use Model\Producto;
use Model\Receta;
use Model\RecetaIngredientes;
use Model\UnidadMedida;
use MVC\Router;

class RecetaController {

    public static function mostrar(Router $router) {
        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $recetas = Receta::all();
        $ingredientesReceta = RecetaIngredientes::all();

        $producto=Producto::all();
        $categoria = Categoria::all();
        $medidas = UnidadMedida::all();

        foreach ($ingredientesReceta as $ingredienteReceta) {
            $ingredienteReceta->receta = Receta::find($ingredienteReceta->id);
            $ingredienteReceta->producto = Producto::find($ingredienteReceta->productoId);
        }

        

        $resultado = $_GET['resultado'] ?? null;

        $router->render('recetas/mostrar', [
            'recetas' => $recetas,
            'ingredientesReceta' => $ingredientesReceta,
            'resultado' => $resultado
        ]);
    }

    public static function crear(Router $router) {
        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }

        $recetas = new Receta;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $recetas->sincronizar($_POST);
            $alertas = $recetas->validar();

            if(empty($alertas)){
                $resultado = $recetas->existeReceta();

                if($resultado->num_rows) {
                    $alertas = Receta::getAlertas();
                } else {
                    $resultado = $recetas->guardar();
                    if($resultado) {
                        Receta::setAlerta('exito', 'Se ha creado una nueva receta');
                    }        
                }  
            }
        }

        $alertas = Receta::getAlertas();

        $router->render('recetas/crear', [
            'recetas' => $recetas,
            'alertas' => $alertas
        ]);
    }

    public static function carritoIngredientes(Router $router) {
        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }
    
        $alertas = [];
        $recetas = Receta::all();
        $productos = Producto::all();
        $orden = $_SESSION["carritoIngredientes"] ?? [];
    
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productoId = intval($_POST['productoId']);
            $recetaId = intval($_POST['recetaId']);
            $cantidad = intval($_POST['cantidad']);
    
            // Verificar si ya existe un ingrediente con la misma receta y el mismo producto
            $indice = null;
            foreach ($orden as $key => $item) {
                if ($item['recetaId'] == $recetaId && $item['productoId'] == $productoId) {
                    $indice = $key;
                    break;
                }
            }
    
            if($indice !== null) {
                // Si el ingrediente existe, sumar la cantidad
                $orden[$indice]['cantidad'] += $cantidad;
            } else {
                // Si el ingrediente no existe, agregar un nuevo ingrediente a la lista
                $orden[] = [
                    'recetaId' => $recetaId,
                    'productoId' => $productoId,
                    'nombre' => Producto::find($productoId)->nombre,
                    'cantidad' => $cantidad
                ];
            }
    
            $_SESSION['carritoIngredientes'] = $orden;
            Receta::setAlerta('exito', 'Producto agregado al carrito');
            
            header('Location: /recetas/carritoIngredientes');
            exit;
        }
    
        $alertas = Receta::getAlertas();
    
        $router->render('recetas/carritoIngredientes', [
            'recetas' => $recetas,
            'productos' => $productos,
            'orden' => $orden,
            'alertas' => $alertas
        ]);
    }

    public static function eliminarIngredienteCarrito() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productoId = $_POST['productoId'];
            $orden = $_SESSION["carritoIngredientes"];

            $orden = array_filter($orden, function($item) use ($productoId) {
                return $item["productoId"] != $productoId;
            });

            $_SESSION["carritoIngredientes"] = $orden;
            Receta::setAlerta('exito', 'Producto eliminado del carrito de ingredientes');
            header("Location: /recetas/carritoIngredientes");
            exit;
        }
    }

    public static function vaciarCarritoIngredientes() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            unset($_SESSION["carritoIngredientes"]);
            Receta::setAlerta('exito', 'Carrito de ingredientes vaciado');
            header("Location: /recetas/carritoIngredientes");
            exit;
        }
    }

    public static function guardarRecetaIngredientes(Router $router) {
        isAuth();
        if(!isAdmin()) {
            header('Location: /templates/error403');
        }
    
        // Obtener los datos del carrito de ingredientes de la sesión
        $orden = $_SESSION["carritoIngredientes"] ?? [];

        // Recorrer los datos del carrito de ingredientes y guardar cada ingrediente en la tabla receta_ingredientes
        foreach ($orden as $item) {
            $recetaIngrediente = new RecetaIngredientes;
            $recetaIngrediente->recetaId = intval($item['recetaId']);
            $recetaIngrediente->productoId = intval($item['productoId']);
            $recetaIngrediente->cantidad = $item['cantidad'];
            $recetaIngrediente->guardar();
        }
        

        //debug($recetaIngrediente);
    
        // Eliminar los datos del carrito de ingredientes de la sesión
        unset($_SESSION["carritoIngredientes"]);
    
        // Redirigir a una página de éxito o a donde desees
        header('Location: /recetas/carritoIngredientes');
        exit;
    }

    

}
