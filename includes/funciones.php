<?php

// Debug - Visualización de datos
function debug($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Sanitización del HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function pagina_actual($path) {
    return str_contains($_SERVER['PATH_INFO'], $path) ? true : false;
}

function contieneURL($currentUrl, $url) {
    return str_contains($currentUrl,  $url);
}

function validarORedireccionar(string $url){
    // Validar la URL por un id valido

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header("Location: {$url}");
    }

    return $id;
}


// // Función que revisa que el usuario este autenticado
// function is_auth() : bool {
//     session_start();
//     return $_SESSION['nombre'] && !empty($_SESSION);
// }

// function is_admin() : bool {
//     session_start();
//     return $_SESSION['rol'] && ( $_SESSION['rol'] === '3');
// }



// Función que revisa que el usuario este autenticado
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

function isAdmin() : bool {
    //session_start();
    if($_SESSION['rol'] === 'Administrador') {
        return true;
    } else {
        return false;
    }
}

function isEncargado() : bool {
    //session_start();
    if($_SESSION['rol'] === 'Encargado') {
        return true;
    } else {
        return false;
    }
}

function tieneRol() : bool {
    //session_start();
    if($_SESSION['rol'] === 'Administrador' || $_SESSION['rol'] === 'Encargado') {
        return true;
    } else {
        return false;
    }
}

