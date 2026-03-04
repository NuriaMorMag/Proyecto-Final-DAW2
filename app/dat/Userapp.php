<?php
/**
 * DTO (Data Transfer Object) 
 * Representa 1 fila de la tabla userapp: Un usuario tiene id, login y contraseña
 */

class Userapp {
    public $login;
    public $name;
    public $password;
    public $email;

  // Getter con método mágico
    public function __get($attribute){
        if(property_exists($this, $attribute)) {
            return $this->$attribute;
        }
    }
    // Setter con método mágico
    public function __set($attribute,$value){
        if(property_exists($this, $attribute)) {
            $this->$attribute = $value;
        }
    }
}