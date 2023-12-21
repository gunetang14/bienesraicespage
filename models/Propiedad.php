<?php

namespace Model;

#[\AllowDynamicProperties]
class Propiedad extends ActiveRecord {

    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id','titulo','precio','imagen','descripcion','habitaciones','wc','estacionamientos','creado','vendedores_id'];
    
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamientos;
    public $creado;
    public $vendedores_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamientos = $args['estacionamientos'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function validar(){

        if(!$this->titulo) { 
            self::$errores[] = "Debes agregar un titulo";
        }
        if(!$this->precio) {
            self::$errores[] = "Debes agregar un precio";
        }
        if(strlen($this->descripcion) < 50 ) {
            self::$errores[] = "Debes agregar una descripcion";
        }
        if(!$this->habitaciones) {
            self::$errores[] ="Debes agregar numero de las habitaciones";
        }
        if(!$this->wc) {
            self::$errores[] ="Debes agregar numero de baños";
        }
        if(!$this->estacionamientos) {
            self::$errores[] ="Debes agregar el numero de estacionamientos";
        }
        if(!$this->vendedores_id) {
            self::$errores[] ="Debes agregar el vendedor";
        }
        if(!$this->imagen) {
            self::$errores[] = "La Imágen de la Propiedad es Obligatoria";
        }
        

        return self::$errores;
    }
    
}

?>