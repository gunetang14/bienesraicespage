<?php

namespace Controllers;
use MVC\Router;
use Model\Admin;

#[\AllowDynamicProperties]
class LoginController {
    public static function login(Router $router){
        
        $errores = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $auth = new Admin($_POST);
            $errores = $auth->validar();

            if(empty($errores)){
                //verificar el usuario
                $resultado = $auth->existeUsuario();
                
                if(!$resultado){
                    $errores = Admin::getErrores();
                } else {
                    //verificar el password
                    $autenticado = $auth->comprobarPassword($resultado);
                    if($autenticado) {
                        //autenticar el usuario
                        $auth->autenticar();

                    }
                        // password incorrecto y mensaje de error
                        $errores = Admin::getErrores();
                }
                
            }
        }

        $router->render('auth/login', [
            'errores' => $errores
        ]);
    }

    public static function logout(){
        
        session_start();
        $_SESSION = [];
        
        header('Location: /');
    }


}


?>