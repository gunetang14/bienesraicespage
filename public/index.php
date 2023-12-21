<?php

    require_once __DIR__ . '/../includes/app.php';

    use MVC\Router;
    use Controllers\PropiedadController;
    use Controllers\VendedoresController;
    use Controllers\PaginasController;
    use Controllers\LoginController;

    $router = new Router();
    // Zona Privada
    $router->get('/admin', [PropiedadController::class, 'index']);
    //Propiedades
    $router->get('/propiedades/crear', [PropiedadController::class, 'crear']);
    $router->post('/propiedades/crear', [PropiedadController::class, 'crear']);
    $router->get('/propiedades/actualizar',[PropiedadController::class, 'actualizar']);
    $router->post('/propiedades/actualizar',[PropiedadController::class, 'actualizar']);
    $router->post('/propiedades/eliminar',[PropiedadController::class, 'eliminar']);
    //vendedores
    $router->get('/vendedores/crear', [VendedoresController::class, 'crear']);
    $router->post('/vendedores/crear', [VendedoresController::class, 'crear']);
    $router->get('/vendedores/actualizar',[VendedoresController::class, 'actualizar']);
    $router->post('/vendedores/actualizar',[VendedoresController::class, 'actualizar']);
    $router->post('/vendedores/eliminar',[VendedoresController::class, 'eliminar']);

    //Zona Publica
    $router->get('/', [PaginasController::class, 'index']);
    $router->get('/nosotros', [PaginasController::class, 'nosotros']);
    $router->get('/propiedades', [PaginasController::class, 'propiedades']);
    $router->get('/propiedad', [PaginasController::class, 'propiedad']);
    $router->get('/blog', [PaginasController::class, 'blog']);
    $router->get('/entrada', [PaginasController::class, 'entrada']);
    $router->get('/contacto', [PaginasController::class, 'contacto']);
    $router->post('/contacto', [PaginasController::class, 'contacto']);

    // Login y Autenticacion
    $router->get('/login', [LoginController::class, 'login']);
    $router->post('/login', [LoginController::class, 'login']);
    $router->get('/logout', [LoginController::class, 'logout']);

    $router->comprobarRutas();



?>

