<?php

namespace Model;

#[\AllowDynamicProperties]
class Admin extends ActiveRecord {
    //base de datos
    protected static $tabla = 'usuarios';
    protected static $columnas = ['id', 'correo', 'password'];

    public $id;
    public $correo;
    public $password;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->correo = $args['correo'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar(){
        if(!$this->correo){
            self::$errores[] = 'El correo es obligatorio';
        }
        if(!$this->password){
            self::$errores[] = 'El  password es obligatorio';
        }
        return self::$errores;
    }

    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE correo = '" . $this->correo . "' LIMIT 1";
        $resultado = self::$db->query($query);
        if(!$resultado->num_rows){
            self::$errores[] = 'El Usuario no Existe';
            return;
        }
        return $resultado;
    }

    public function comprobarPassword($resultado){
        $usuario = $resultado->fetch_object();
        $autenticado = password_verify($this->password, $usuario->password);
        if(!$autenticado){
            self::$errores[] = 'El password es incorrecto';
            
        }
        return $autenticado;
    }
    public function autenticar(){

        session_start();
        //llenar el arreglo de session
        $_SESSION['usuario'] = $this->correo;
        $_SESSION['login'] = true;
        header('Location: /admin');
    }
}


?>