<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . '/funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');


function incluirTemplate(string $nombre, bool $inicio = false){
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estaAutenticado(){
    session_start();
    if(!$_SESSION['login']){
        header('Location: /');
    }
}

function debuguear($debug) {
    echo "<pre>";
    var_dump($debug);
    echo "</pre>";
    exit;
}

function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//validar tipo de contenido4
function validarTipoContenido($tipo){
    $tipos = ['vendedor', 'propiedad'];

    return in_array($tipo, $tipos);
}

//muestrra los errores

function mostrarNotificaciones($codigo) {
    $mensaje = '';

    switch($codigo) {
        case 1: 
            $mensaje = 'Creado Correctamente';
            break;
        case 2: 
            $mensaje = 'Actualizado Correctamente';
            break;
        case 3: 
            $mensaje = 'Eliminado Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}

function probando(){
    echo "Prueba";
}

function validarORedireccionar(string $url){

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

   

    if(!$id) {
        header("Location: {$url}");
    }
    return $id;

}