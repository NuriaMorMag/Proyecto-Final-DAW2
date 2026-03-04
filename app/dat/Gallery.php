<?php
/**
 * DTO (Data Transfer Object) 
 * Representa 1 fila de la tabla userapp: Un usuario tiene id, login y contraseña
 */

class Gallery
{
    public $id;
    public $title;
    public $path;
    public $alt;
    public $category;
    public $date;
    public $commentary;
    public $is_blog;

    // Getter con método mágico 
    public function __get($attribute)
    {
        if (property_exists($this, $attribute)) {
            return $this->$attribute;
        }
    }

    // Setter con método mágico 
    public function __set($attribute, $value)
    {
        if (property_exists($this, $attribute)) {
            $this->$attribute = $value;
        }
    }
}
