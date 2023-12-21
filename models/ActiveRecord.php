<?php

namespace Model;

#[\AllowDynamicProperties]
class ActiveRecord {

    //Base de Datos

    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    // errores
    protected static $errores = [];

    

    //Definir la conexion a la Base de Datos
    public static function setDB($database){
        self::$db = $database;
    }

   
    public function guardar() {
        
        if(!is_null($this->id)) {
            // actualizar
            
            $this->actualizar();
        } else {
            // crear
            $this->crear();
        }
    }
    
    public function crear(){

        //sanitizar
        $atributos = $this->sanitizarAtributos();
        
        // Insertar en la base de datos
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos)); 
        $query .= " ) VALUES (' "; 
        $query .= join("', '",array_values($atributos));
        $query .= " '); ";

        $res = self::$db->query($query);

        //MENSAJE DE EXITO
        if($res){
            //Redireccionando al usuario
            header('Location: /admin?resultado=1');
        }

        
        
    }

    public function actualizar(){
        //sanitizar
        
        $atributos = $this->sanitizarAtributos();
        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'";
        }
        
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ',$valores);
        $query .= "WHERE id= '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";
        
        $res = self::$db->query($query);
        //MENSAJE DE EXITO
        if($res){
            //Redireccionando al usuario
            header('Location: /admin?resultado=2');
        }
        
    }

    public function eliminar(){
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
    
        if($resultado){
            $this->borrarImagen();
            header('location: /admin?resultado=3');
        }
    }

    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value) {
            
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;

    }
    //subida de la imagen
    public function setImage($imagen) {
        if(!is_null($this->id)){
            $this->borrarImagen();
            
        }

        if($imagen){
            $this->imagen = $imagen;
        }
    }

    //Eliminar Imagen
    public function borrarImagen(){
        //comprobando si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo){
            unlink(CARPETA_IMAGENES . $this->imagen);
        }

    }
    
    //validacion
    public static function getErrores(){
    
        return static::$errores;
    }
    public function validar(){

        static::$errores = [];
        return static::$errores;
    }

    public static function all(){
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;        
    }
    //obtiene un numero de registros
    public static function get($cantidad){
        $query = "SELECT * FROM " . static::$tabla . " LIMIT ". $cantidad;
        $resultado = self::consultarSQL($query);
        return $resultado;
        
    }

    // busca un registro por su id
    public static function find($id){
        //consulta para obtener las propiedades
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function consultarSQL($query) {
        //consultar base de datos
        $resultado = self::$db->query($query); 
        
        //iterar los resultados para sacarlos todos
        $array = [];
        while($registro = $resultado->fetch_assoc()):
            $array[] = static::crearObjeto($registro);
        endwhile;

        //liberar memoria
        $resultado->free();

        //retornar los resultados
        return $array;

    }
    protected static function crearObjeto($registro) {
        $objeto = new static;
        foreach($registro as $key => $value) {
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }
    //sincornizar el objeto en memoria caon los cambios realizados por el usuario
    public function sincronizar( $args = []) {
        foreach($args as $key => $value) {
            if( property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

}


?>