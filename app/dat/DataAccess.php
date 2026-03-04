<?php

/**
 * DAO — Data Access Object
 * Clase que habla con la BD
 */

require_once "Userapp.php";
require_once "Gallery.php";
require_once "app/config.php";

class DataAccess
{
    private static $model = null; //Guarda la única instancia de la clase (Singleton)
    private $connection = null; //Conexión a la bd

    // Sentencias preparadas
    private $stmt_getUser = null;
    private $stmt_addUser = null;

    private $stmt_allImages = null;
    private $stmt_imagesByCategory = null;
    private $stmt_getImageById = null;
    private $stmt_addImage = null;
    private $stmt_updateImage = null;
    private $stmt_deleteImage = null;
    private $stmt_getBlogPosts = null;

    /*
    Si no existe el objeto, lo crea
    Hace que no haya dos conexiones a la BD
    */
    public static function getModel()
    {
        if (self::$model == null) {
            self::$model = new DataAccess();
        }
        return self::$model;
    }

    //Privado para que solo la propia clase pueda crear el objeto
    //No se puede hacer new DataAccess(); pero sí DataAccess::getModel();
    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . SERVER_DB . ";dbname=" . DATABASE . ";charset=utf8";
            $this->connection = new PDO($dsn, DB_USER, DB_PASSWD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //si hay un error se lanza una excepcion 
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //MySQL arma la consulta con valores separados (recibe el valor por separado)
        } catch (PDOException $e) {
            echo "Database connection failed " . $e->getMessage();
            exit();
        }

        // PREPARO TODAS LAS SENTENCIAS UNA SOLA VEZ
        try {
            $this->stmt_getUser = $this->connection->prepare("SELECT * FROM userapp WHERE login = :login");
            $this->stmt_addUser = $this->connection->prepare("INSERT INTO userapp (login, name, email, password) VALUES (:login, :name, :email, :password)");
            $this->stmt_allImages = $this->connection->prepare("SELECT * FROM gallery");
            $this->stmt_imagesByCategory = $this->connection->prepare("SELECT * FROM gallery WHERE category = :cat");
            $this->stmt_getImageById = $this->connection->prepare("SELECT * FROM gallery WHERE id = :id");
            $this->stmt_addImage = $this->connection->prepare("INSERT INTO gallery (title, path, alt, category, date, commentary, is_blog) VALUES (:t, :p, :a, :cat, :d, :com, :b)");
            $this->stmt_updateImage = $this->connection->prepare("UPDATE gallery SET title = :t, alt = :a, category = :cat, date = :d, commentary = :com, is_blog = :b WHERE id = :id");
            $this->stmt_deleteImage = $this->connection->prepare("DELETE FROM gallery WHERE id = :id");
            $this->stmt_getBlogPosts = $this->connection->prepare("SELECT * FROM gallery WHERE is_blog = 1 ORDER BY date DESC");
            
        } catch (PDOException $e) {
            echo " Error creating statements " . $e->getMessage();
            exit();
        }
    }

    //Cierra la conexión anulando todos los objectos relacioanado con la conexión PDO (stmt)
    public static function closeModel()
    {
        if (self::$model != null) {
            $obj = self::$model;
            $obj->stmt_getUser = null;
            $obj->stmt_addUser = null;
            $obj->stmt_allImages = null;
            $obj->stmt_imagesByCategory = null;
            $obj->stmt_getImageById = null;
            $obj->stmt_addImage = null;
            $obj->stmt_updateImage = null;
            $obj->stmt_deleteImage = null;
            $obj->stmt_getBlogPosts = null;
            $obj->connection = null;
            self::$model = null;
        }
    }

    //Devuelve un usuario o false
    public function getUser(String $login)
    {
        $user = false;

        $this->stmt_getUser->setFetchMode(PDO::FETCH_CLASS, 'Userapp'); //Indica que los resultados de la consulta deben devolverse como objetos de la clase Userapp.
        $this->stmt_getUser->bindParam(':login', $login);

        if ($this->stmt_getUser->execute()) {
            if ($obj = $this->stmt_getUser->fetch()) {
                $user = $obj;
            }
        }
        return $user;
    }

    // Añadir usuario al registrarse
    public function addUser($user)
    {
        $this->stmt_addUser->bindValue(':login', $user->login);
        $this->stmt_addUser->bindValue(':name', $user->name);
        $this->stmt_addUser->bindValue(':email', $user->email);
        $this->stmt_addUser->bindValue(':password', $user->password);
        return $this->stmt_addUser->execute();
    }

    // Devuelve todas las imágenes
    public function getAllImages()
    {
        $this->stmt_allImages->execute();
        return $this->stmt_allImages->fetchAll(PDO::FETCH_CLASS, "Gallery");
    }

    // Devuelve las imágenes por categoría
    public function getImagesByCategory($category)
    {
        $this->stmt_imagesByCategory->bindParam(":cat", $category);
        $this->stmt_imagesByCategory->execute();
        return $this->stmt_imagesByCategory->fetchAll(PDO::FETCH_CLASS, "Gallery");
    }

    // Obtener una imagen por ID 
    public function getImageById($id)
    {
        $this->stmt_getImageById->bindValue(':id', $id, PDO::PARAM_INT);
        $this->stmt_getImageById->setFetchMode(PDO::FETCH_CLASS, 'Gallery');
        $this->stmt_getImageById->execute();
        return $this->stmt_getImageById->fetch();
    }

    /* AÑADIR, MODIFICAR O ELIMINAR IMÁGENES */
    // Añadir imagen
    public function addImage($title, $path, $alt, $category, $date, $commentary, $is_blog)
    {
        $this->stmt_addImage->bindValue(':t', $title);
        $this->stmt_addImage->bindValue(':p', $path);
        $this->stmt_addImage->bindValue(':a', $alt);
        $this->stmt_addImage->bindValue(':cat', $category);
        $this->stmt_addImage->bindValue(':d', $date);
        $this->stmt_addImage->bindValue(':com', $commentary);
        $this->stmt_addImage->bindValue(':b', $is_blog);
        return $this->stmt_addImage->execute();
    }

    // Actualizar imagen
    public function updateImage($id, $title, $alt, $category, $date, $commentary, $is_blog)
    {
        $this->stmt_updateImage->bindValue(':t', $title);
        $this->stmt_updateImage->bindValue(':a', $alt);
        $this->stmt_updateImage->bindValue(':cat', $category);
        $this->stmt_updateImage->bindValue(':d', $date);
        $this->stmt_updateImage->bindValue(':com', $commentary);
        $this->stmt_updateImage->bindValue(':b', $is_blog);
        $this->stmt_updateImage->bindValue(':id', $id, PDO::PARAM_INT);
        return $this->stmt_updateImage->execute();
    }

    // Eliminar imagen
    public function deleteImage($id)
    {
        $this->stmt_deleteImage->bindValue(':id', $id, PDO::PARAM_INT);
        return $this->stmt_deleteImage->execute();
    }

    // Obtener datos para el blog
    public function getBlogPosts()
    {
        $this->stmt_getBlogPosts->execute();
        return $this->stmt_getBlogPosts->fetchAll(PDO::FETCH_CLASS, "Gallery");
    }
  

    // Evita la clonación del Singleton 
    public function __clone()
    {
        trigger_error("You cannot clone a Singleton", E_USER_ERROR);
    }
}
