<?php
/**
 * DTO (Data Transfer Object)
 * Represents one row from the 'userapp' table
 */

class Userapp {
    public $login;
    public $name;
    public $password;
    public $email;

    public function __get($attribute){
        if(property_exists($this, $attribute)) {
            return $this->$attribute;
        }
    }

    public function __set($attribute,$value){
        if(property_exists($this, $attribute)) {
            $this->$attribute = $value;
        }
    }
}