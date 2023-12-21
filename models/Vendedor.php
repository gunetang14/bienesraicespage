<?php

namespace Model;

#[\AllowDynamicProperties]
class Vendedor extends ActiveRecord {

    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id','nombre','apellido','telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar(){

        if(!$this->nombre) { 
            self::$errores[] = "Nombre Obligatorio";
        }
        if(!$this->apellido) {
            self::$errores[] = "Apellido Obligatorio";
        }
        if(!$this->telefono) { 
            self::$errores[] = "Telefono Obligatorio";
        }
        if(!preg_match('/[0-9]{10}/',$this->telefono)) {
            self::$errores[] = "Formato de Teléfono no Válido";
        }
        return self::$errores;
    }
}




?>