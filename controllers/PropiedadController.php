<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

#[\AllowDynamicProperties]
class PropiedadController {
    public static function index(Router $router){
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $resultado = $_GET['resultado'] ?? null;
        
        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'vendedores' => $vendedores,
            'resultado' => $resultado
        ]);      
    }
    public static function crear(Router $router){
        $propiedades = new Propiedad();
        $vendedores = Vendedor::all();

        $errores = Propiedad::getErrores();

            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                $propiedades = new Propiedad($_POST['propiedad']);
        
                //SUBIDA DE ARCHIVOS
                // crear carpeta              
        
                //generar nombre de imagen para guardar
                $nombreImagen = md5(uniqid( rand(), true )) . ".jpg";
        
                if($_FILES['propiedad']['tmp_name']['imagen']){
                    // realiza resize a imagen
                    $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                    $propiedades->setImage($nombreImagen);
                }
                
                $errores = $propiedades->validar();
                
                if(empty($errores)){
                                
                    if(!is_dir(CARPETA_IMAGENES)) {
                        mkdir(CARPETA_IMAGENES);
                    }
                    //guarda la imagen en el servidor
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
        
                    //GUARDA EN BBDD
                    $propiedades->guardar();
        
                    
                }
            }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedades,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router){
        $id = validarORedireccionar('/admin');
        $propiedades = Propiedad::find($id);
        $vendedores = Vendedor::all(); 
 
        // arreglo con mensajes de errores
        $errores = Propiedad::getErrores();
        
        
            //ejecuta el codigo despeus que el usuario envia el formualrio
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                
                $args = $_POST['propiedad'];
                
                $propiedades->sincronizar($args);
                
                //validacion
                $errores = $propiedades->validar();

                ////generar nombre de imagen para guardar
                $nombreImagen = md5(uniqid( rand(), true )) . ".jpg";

                if($_FILES['propiedad']['tmp_name']['imagen']){
                    // realiza resize a imagen
                    $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                    $propiedades->setImage($nombreImagen);
                }
                
                if(empty($errores)){
                    if($_FILES['propiedad']['tmp_name']['imagen']){
                        //guarda la imagen en el servidor
                        $image->save(CARPETA_IMAGENES . $nombreImagen);     
                    }
                    //GUARDA EN BBDD
                    $propiedades->guardar();                           
                }
            }
        

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedades,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);

    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
        
                $id = $_POST['id'];
                $id = filter_var($id, FILTER_VALIDATE_INT);
                
                if($id){
        
                    $tipo = $_POST['tipo'];
                    if(validarTipoContenido($tipo)){
                        $propiedad = Propiedad::find($id);
                        $propiedad->eliminar();
                        
                    }   
                              
                }
             


        }





    }

    
       
       

}