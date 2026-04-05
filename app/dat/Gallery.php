<?php
/**
 * DTO (Data Transfer Object) 
 * Represents one row from the 'gallery' table
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

    public function __get($attribute)
    {
        if (property_exists($this, $attribute)) {
            return $this->$attribute;
        }
    }

    public function __set($attribute, $value)
    {
        if (property_exists($this, $attribute)) {
            $this->$attribute = $value;
        }
    }
}
