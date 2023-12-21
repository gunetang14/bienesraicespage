<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

#[\AllowDynamicProperties]
class PaginasController {
    public static function index(Router $router) {

        $propiedades = Propiedad::get(3);
        $inicio = true;
        $router->render('/paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }

    public static function nosotros(Router $router) {
        $router->render('/paginas/nosotros',[]);
    }

    public static function propiedades(Router $router) {
        $propiedades = Propiedad::all();
        
        $router->render('/paginas/propiedades', [
            'propiedades' => $propiedades,
        ]);
    }

    public static function propiedad(Router $router) {
        $id = validarORedireccionar('/propiedades');
        $propiedad = Propiedad::find($id);

        $router->render('/paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }

    public static function blog(Router $router) {
        $router->render('/paginas/blog');
    }

    public static function entrada(Router $router) {
        $router->render('/paginas/entrada');
    }

    public static function contacto(router $router) {
        $mensaje = null;
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respuestas = $_POST['contacto'];

            //Crear una nueva instancia de PHPMailer            
            $mail = new PHPMailer();
            
            //Configurar SMTP
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];
            $mail->SMTPSecure = 'tls';
            
            //Configurar el contenido del email
            $mail->setFrom($_ENV['EMAIL_MAIL']);
            $mail->addAddress($_ENV['EMAIL_MAIL']);
            $mail->Subject = 'Tienes un Nuevo Mensaje';

            //Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            //Definir el contenido
            $contenido = '<html>';
            $contenido .= ' <p>Tienes un nuevo Mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre']  . ' </p>';

            if($respuestas['contacto'] === 'telefono'){
                $contenido .= '<p>Eligió ser contactado por Teléfono: </p>';
                $contenido .= '<p>Telefono: ' . $respuestas['telefono']  . ' </p>';
                $contenido .= '<p>Fecha Contacto: ' . $respuestas['fecha']  . ' </p>';
                $contenido .= '<p>Hora: ' . $respuestas['hora']  . ' </p>';
            } else {
                $contenido .= '<p>Eligió ser contactado por Email </p>';
                $contenido .= '<p>Email: ' . $respuestas['email']  . ' </p>';
            }
            
            
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje']  . ' </p>';
            $contenido .= '<p>Vende o Compra: ' . $respuestas['tipo']  . ' </p>';
            $contenido .= '<p>Precio o Presupuesto: $' . $respuestas['precio']  . ' </p>';
            $contenido .=' </html>';

            $mail->Body = $contenido;
            //Enviar el mail
            if($mail->send()){
                $mensaje = "Mensaje Enviado Correctamente";
            } else {
                $mensaje = "Mensaje No Enviado";
            }
        }



        $router->render('/paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }

}