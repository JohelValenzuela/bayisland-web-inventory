<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Categoria;
use Model\Producto;
use Model\Receta;
use Model\UnidadMedida;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

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
            exit;
        }
    
        $producto = new Producto;
        $medidas = UnidadMedida::all();
        $categoria = Categoria::all();
        $producto->estado = "Activo";
        $alertas = [];
    
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sincroniza producto
            $producto->sincronizar($_POST);

            
    
            // Maneja la subida de archivos
            if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                // Generar nombre único
                $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
                $imageTmpName = $_FILES['imagen']['tmp_name'];

                
    
                // Realiza un resize a la imagen con Intervention
                $image = Image::make($imageTmpName)->fit(800, 600);
                // Guarda la imagen en el servidor
                $uploadDir = '../src/img/';
                $uploadFile = $uploadDir . $nombreImagen;
                $image->save($uploadFile);
                
                
                // Asigna el nombre de la imagen al producto
                $producto->imagen_nombre = $nombreImagen;
                
            }
    
            // Validaciones
            $alertas = $producto->validar();
    
            // Cálculo de precios
            $totalMedida = $producto->totalMedida;
            $precioMedida = $producto->precioMedida;
            $precioUnidad = $producto->precioUnidad;
            $subtotal = $totalMedida * $precioMedida;
            $total = $subtotal + $precioUnidad;
    
            $producto->total = $total;
    
            if(empty($alertas)) {
                $resultado = $producto->guardar();
                if ($resultado) {
                    Producto::setAlerta('exito', 'Se ha creado un nuevo producto');
                    header('Location: /producto?resultado=1');
                    exit;
                }
            }
        }
    
        $alertas = Producto::getAlertas();
        $router->render('/producto/crear', [
            'producto' => $producto,
            'alertas' => $alertas,
            'medidas' => $medidas,
            'categoria' => $categoria
        ]);
    }

    public static function actualizar(Router $router) {
        isAuth();
        if (!isAdmin()) {
            header('Location: /templates/error403');
        }
    
        $categoria = Categoria::all();
        $medidas = UnidadMedida::all();
    
        $id = validarORedireccionar('/producto'); 
        $producto = Producto::find($id);
    
        $alertas = [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sincronizar el producto con los datos del formulario
            $producto->sincronizar($_POST);
    
            // Validar el producto
            $alertas = $producto->validar();
    
            // Calcular el total
            $totalMedida = $producto->totalMedida; // Cantidad de Medida (Onza)
            $precioMedida = $producto->precioMedida; // Precio por Medida (Onza)
            $precioUnidad = $producto->precioUnidad; // Precio por Producto
            $subtotal = $totalMedida * $precioMedida; // Subtotal
            $total = $subtotal + $precioUnidad;
            $producto->total = $total;
    
            // Manejar la subida de la nueva imagen
            if ($_FILES['imagen']['tmp_name']) {
                // Generar un nombre único para la nueva imagen
                $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
                $rutaImagen = '../src/img/' . $nombreImagen;
    
                // Realizar un resize a la imagen con Intervention
                $imagen = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600);
                $imagen->save($rutaImagen);
    
                // Asignar el nombre de la imagen al producto
                $producto->imagen_nombre = $nombreImagen;
            }
    
            // Revisar que el array de errores esté vacío
            if (empty($alertas)) {
                // Guardar el producto en la base de datos
                $resultado = $producto->guardar();
    
                if ($resultado) {
                    Producto::setAlerta('exito', 'Se ha actualizado el producto');
                    header('Location: /producto');
                    return;
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