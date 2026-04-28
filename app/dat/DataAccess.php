<?php

/**
 * DAO — Data Access Object
 * This class communicates with DB
 */

require_once "Userapp.php";
require_once "Gallery.php";
require_once "app/config.php";

class DataAccess
{
    private static $model = null; // Stores the single instance of this class (Singleton)
    private $connection = null; // DB connection

    // Prepared statements
    private $stmt_getUser = null;
    private $stmt_addUser = null;

    private $stmt_allImages = null;
    private $stmt_imagesByCategory = null;
    private $stmt_getImageById = null;
    private $stmt_addImage = null;
    private $stmt_updateImage = null;
    private $stmt_deleteImage = null;
    private $stmt_getBlogPosts = null;
    private $stmt_addMessage = null;


    // If the object does not exist, creates it
    // Ensures there's only one DB connection
    public static function getModel()
    {
        if (self::$model == null) {
            self::$model = new DataAccess();
        }
        return self::$model;
    }

    // Private so only this class can create the object
    // You cannot do "new DataAccess()", but you can call DataAccess::getModel()
    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . SERVER_DB . ";dbname=" . DATABASE . ";charset=utf8";
            $this->connection = new PDO($dsn, DB_USER, DB_PASSWD);

            // Throw exceptions when errors occur
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // MySQL constructs the query using separate values (it receives each value individually)
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            echo "Database connection failed " . $e->getMessage();
            exit();
        }

        // PREPARE ALL STATEMENTS ONLY ONCE
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
            $this->stmt_addMessage = $this->connection->prepare("INSERT INTO contact_messages (name, email, phone, message) VALUES (:name, :email, :phone, :message)");
        } catch (PDOException $e) {
            echo " Error creating statements " . $e->getMessage();
            exit();
        }
    }

    // Close the connection by removing all PDO-related objects
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

    // Returns a user object or false
    public function getUser(String $login)
    {
        $user = false;

        // Indicates that the query results should be returned as objects of the Userapp class
        $this->stmt_getUser->setFetchMode(PDO::FETCH_CLASS, 'Userapp');
        $this->stmt_getUser->bindParam(':login', $login);

        if ($this->stmt_getUser->execute()) {
            if ($obj = $this->stmt_getUser->fetch()) {
                $user = $obj;
            }
        }
        return $user;
    }

    // Add a new user during registration
    public function addUser($user)
    {
        $this->stmt_addUser->bindValue(':login', $user->login);
        $this->stmt_addUser->bindValue(':name', $user->name);
        $this->stmt_addUser->bindValue(':email', $user->email);
        $this->stmt_addUser->bindValue(':password', $user->password);
        return $this->stmt_addUser->execute();
    }

    // Return all images
    public function getAllImages()
    {
        $this->stmt_allImages->execute();
        return $this->stmt_allImages->fetchAll(PDO::FETCH_CLASS, "Gallery");
    }

    // Return images by category
    public function getImagesByCategory($category)
    {
        $this->stmt_imagesByCategory->bindParam(":cat", $category);
        $this->stmt_imagesByCategory->execute();
        return $this->stmt_imagesByCategory->fetchAll(PDO::FETCH_CLASS, "Gallery");
    }

    // Get an image by ID 
    public function getImageById($id)
    {
        $this->stmt_getImageById->bindValue(':id', $id, PDO::PARAM_INT);
        $this->stmt_getImageById->setFetchMode(PDO::FETCH_CLASS, 'Gallery');
        $this->stmt_getImageById->execute();
        return $this->stmt_getImageById->fetch();
    }

    /* ADD, UPDATE OR DELETE IMAGES */
    // Add image
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

    // Update image
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

    // Delete image
    public function deleteImage($id)
    {
        $this->stmt_deleteImage->bindValue(':id', $id, PDO::PARAM_INT);
        return $this->stmt_deleteImage->execute();
    }

    // Get blog posts (images marked as blog entries)
    public function getBlogPosts()
    {
        $this->stmt_getBlogPosts->execute();
        return $this->stmt_getBlogPosts->fetchAll(PDO::FETCH_CLASS, "Gallery");
    }

    // Send a message (contact)
    public function addMessage($name, $email, $phone, $message)
    {
        $this->stmt_addMessage->bindValue(':name', $name);
        $this->stmt_addMessage->bindValue(':email', $email);
        $this->stmt_addMessage->bindValue(':phone', $phone);
        $this->stmt_addMessage->bindValue(':message', $message);

        return $this->stmt_addMessage->execute();
    }

    // Prevent cloning of the Singleton
    public function __clone()
    {
        trigger_error("You cannot clone a Singleton", E_USER_ERROR);
    }
}
