<?php
// index.php → controller 

require_once "app/dat/DataAccess.php";
require_once "app/dat/Gallery.php";
require_once "app/functions.php";

session_start();

$message = "";

/* SESSION TIME CONTROL (10 min) 
Antes que nada: si caduca se corta todo
Comprueba si el usuario estaba logueado antes ($_SESSION['timeout'] se define en el proceso login)
Mira cuánto tiempo ha pasado desde la última acción
Si han pasado 10 minutos se cierra la sesión y se vuelve al login
*/
if (isset($_SESSION['timeout'])) {
    if (time() - $_SESSION['timeout'] > 600) {
        session_destroy();
        header("Location: index.php?timeout=1");
        exit();
    }
}

/* LOGOUT */
if (isset($_REQUEST['order']) && $_REQUEST['order'] == "signout") {
    session_destroy();
    header("Location: index.php");
    exit();
}

/* LOGGED-IN USER */
if (isset($_SESSION['user'])) {
    //Cada vez que se interactúa con la página se actualiza el tiempo
    $_SESSION['timeout'] = time();

    $bd = DataAccess::getModel();


    /* ACCIONES SOBRE IMÁGENES (antes del switch de páginas) */

    // ADD IMAGE
    if (isset($_REQUEST['order']) && $_REQUEST['order'] === 'addImage') {

        if (!userCanManageImages()) {
            die('You don\'t have permission to add images.');
        }

        $page = "addImage";  // para que cargue el css correspondiente

        include 'app/layouts/header.php';
        include 'app/layouts/addImage.php';
        include 'app/layouts/footer.php';
        exit();
    }

    // SAVE NEW IMAGE  
    if (isset($_REQUEST['order']) && $_REQUEST['order'] === 'saveImage') {

        if (!userCanManageImages()) {
            die("You don't have permission to save images.");
        }

        $title    = $_POST['title'] === '' ? NULL : $_POST['title']; //Si no se escribe nada: NULL
        $alt = $_POST['alt'];
        $category = $_POST['category'];
        $date = $_POST['date'] === '' ? NULL : $_POST['date'];
        $commentary = $_POST['commentary'] === '' ? NULL : $_POST['commentary'];

        $is_blog = isset($_POST['is_blog']) ? 1 : 0;

        // Upload real image  
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            die("Error uploading image.");
        }

        $path = basename($_FILES['image']['name']);
        $targetPath = "web/img/" . $path;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            die("The image couldn't be saved on the server.");
        }

    
        // OPTIMIZATION after saving

        // Compress the original photo (same size, less file weight)
        // Overwrite the same path ($targetPath): abre la imagen, la comprime, y la guarda en el mismo archivo reemplazando la original
        compressImage($targetPath, $targetPath, 80);

        // Create a thumbnail (smaller image in pixels for the gallery)
        $thumbPath = "web/img/thumbs/" . $path;
        createThumbnail($targetPath, $thumbPath, 600); // 600px de ancho máximo


        if (!file_exists($thumbPath)) {
            die("ERROR: The thumbnail was not created in: " . $thumbPath);
        } else {
            echo "Thumbnail was not created in: " . $thumbPath;
        }

        // Create WebP version (modern and lighter format)
        $webpPath = "web/img/webp/" . pathinfo($path, PATHINFO_FILENAME) . ".webp";
        convertToWebP($targetPath, $webpPath, 80);

        // Create WebP version of the thumbnail 
        $thumbWebpPath = "web/img/webp/thumbs/" . pathinfo($path, PATHINFO_FILENAME) . ".webp";
        convertToWebP($thumbPath, $thumbWebpPath, 70);

        if (!file_exists($thumbWebpPath)) {
            die("ERROR: The WebP of the thumbnail was not created: " . $thumbWebpPath);
        }

        // Save in db 
        $bd->addImage($title,  $targetPath, $alt, $category, $date, $commentary, $is_blog);

        header('Location: index.php?page=gallery');

        echo "<pre>";
        print_r($_POST);
        echo "</pre>";

        exit();
    }

    // EDIT IMAGE
    if (isset($_REQUEST['order']) && $_REQUEST['order'] === 'editImage') {

        if (!userCanManageImages()) {
            die("You don't have permission to edit images.");
        }

        $page = "editImage"; // para que cargue el css correspondiente

        $id = $_GET['id'] ?? NULL;
        if (!$id) {
            die('Image not found.'); //Si el ID está vacío, es 0, es NULL o es falso:
        }

        $image = $bd->getImageById($id);

        include 'app/layouts/header.php';
        include 'app/layouts/editImage.php';
        include 'app/layouts/footer.php';
        exit();
    }

    // UPDATE IMAGE
    if (isset($_REQUEST['order']) && $_REQUEST['order'] === 'updateImage') {

        if (!userCanManageImages()) {
            die("You don't have permission to update images.");
        }

        $id = $_POST['id'] ?? NULL;
        if (!$id) {
            die("Invalid image ID.");
        }

        $title = $_POST['title'] === '' ? NULL : $_POST['title'];
        $alt = $_POST['alt'] ?? '';
        $category = $_POST['category'] ?? '';
        $date = $_POST['date'] === '' ? NULL : $_POST['date'];
        $commentary = $_POST['commentary'] === '' ? NULL : $_POST['commentary'];

        $is_blog = isset($_POST['is_blog']) ? 1 : 0;

        $bd->updateImage($id, $title, $alt, $category, $date, $commentary, $is_blog);

        header('Location: index.php?page=gallery');
        exit();
    }

    // DELETE IMAGE
    if (isset($_REQUEST['order']) && $_REQUEST['order'] === 'deleteImage') {

        if (!userCanManageImages()) {
            die("You don't have permission to delete images.");
        }

        $id = $_GET['id'] ?? null;

        if ($id) {
            $bd->deleteImage($id);
        }

        header('Location: index.php?page=gallery');
        exit();
    }

    // VISTAS
    // Si no se pide ninguna vista, se va a home
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';


    // Browser title changes depending on the page
    switch ($page) {
    case 'home':
        $pageTitle = "Shooting Mood - Photography Portfolio | Nuria Moreno";
        break;

    case 'gallery':
        $pageTitle = "Photo Gallery - Everyday & Event Photography | Shooting Mood";
        break;

    case 'about':
        $pageTitle = "About Me - Photographer Nuria Moreno | Shooting Mood";
        break;

    case 'contact':
        $pageTitle = "Contact - Message Photographer Nuria Moreno | Shooting Mood";
        break;

    case 'blog':
        $pageTitle = "Photography Blog - Behind the Moments & Personal Stories | Shooting Mood";
        break;

    default:
        $pageTitle = "Shooting Mood - Photography Portfolio | Nuria Moreno";
        break;
}


    include "app/layouts/header.php";

    switch ($page) {
        case 'gallery':
            $bd = DataAccess::getModel();
            $images = $bd->getAllImages();
            include "app/layouts/gallery.php";
            break;
        case 'contact':
            include "app/layouts/contact.php";
            break;
        case 'about':
            include "app/layouts/about.php";
            break;
        case 'blog':
            $bd = DataAccess::getModel();
            $posts = $bd->getBlogPosts();
            include "app/layouts/blog.php";
            break;
        default:
            include "app/layouts/home.php";
            break;
    }

    include "app/layouts/footer.php";

    exit();
}

/* GUEST ACCESS */
if (isset($_REQUEST['order']) && $_REQUEST['order'] === 'Sign in as a guest') {
    $_SESSION['guest'] = true;
    header("Location: index.php?page=home");
    exit();
}

/* LOGIN PROCESS */
if (isset($_REQUEST['order']) && $_REQUEST['order'] == "Sign in") {
    $login = $_REQUEST['login'];
    $password = $_REQUEST['password'];

    $bd = DataAccess::getModel();
    $user = $bd->getUser($login);

    if ($user === false) {
        $message = "Incorrect user or password";
    } else {
        if (password_verify($password, $user->password)) {
            $_SESSION['user'] = $user->login;
            $_SESSION['name'] = $user->name;
            $_SESSION['timeout'] = time();
            header("Location: index.php"); //Fuerza a volver a empezar ya con sesión activa para que: isset($_SESSION['user'])
            exit();
        } else {
            $message = "Incorrect user or password";
        }
    }
}

/* REGISTER PROCESS */
if (isset($_REQUEST['order']) && $_REQUEST['order'] == "Create account") {

    $name     = $_REQUEST['name'];
    $login    = $_REQUEST['login'];
    $email     = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $password2 = $_REQUEST['password2'];

    // Validar campos vacíos 
    if (empty($name) || empty($login) || empty($email) || empty($password) || empty($password2)) {
        $message = "All fields are required";
        include "app/layouts/header.php";
        include "app/layouts/register.php";
        include "app/layouts/footer.php";
        exit();
    }

    // Validar contraseñas iguales 
    if ($password !== $password2) {
        $message = "Passwords do not match";
        include "app/layouts/header.php";
        include "app/layouts/register.php";
        include "app/layouts/footer.php";
        exit();
    }

    // Comprobar si ya existe un usuario con ese login
    $bd = DataAccess::getModel();
    $user = $bd->getUser($login);


    if ($user !== false) {
        $message = "This login is already taken";
        include "app/layouts/header.php";
        include "app/layouts/register.php";
        include "app/layouts/footer.php";
        exit();
    }

    // Crear nuevo usuario
    $newUser = new Userapp(); // o el nombre de tu clase de usuario
    $newUser->name  = $name;
    $newUser->login = $login;
    $newUser->email = $email;
    $newUser->password = password_hash($password, PASSWORD_DEFAULT);

    // Guardar usuario en la base de datos
    $bd->addUser($newUser);

    // Iniciar sesión automáticamente 
    $_SESSION['user'] = $newUser->login;
    $_SESSION['name'] = $newUser->name;
    $_SESSION['timeout'] = time();

    // Redirigir a la página principal
    header("Location: index.php");
    exit();
}

/* REGISTER FORM */
if (isset($_REQUEST['order']) && $_REQUEST['order'] == "Sign up") {

    $page = 'login'; //para que se aplique login.css en register.php

    include "app/layouts/header.php";
    include "app/layouts/register.php";
    include "app/layouts/footer.php";
    exit();
}

/* GUEST LOGOUT (volver al login desde modo invitado) */
if (isset($_REQUEST['order']) && $_REQUEST['order'] === 'guest_logout') {
    unset($_SESSION['guest']); // quitamos el modo invitado 
    header("Location: index.php"); // vuelve al flujo normal: mostrará el login 
    exit();
}

/* GUEST MODE */
if (isset($_SESSION['guest']) && !isset($_SESSION['user'])) {

    $page = isset($_GET['page']) ? $_GET['page'] : 'home';

    include "app/layouts/header.php";

    if ($page === 'home') {
        include "app/layouts/home.php";
    } else {
        include "app/layouts/home.php";
    }

    include "app/layouts/footer.php";
    exit();
}

/* LOGIN FORM */
// Si el usuario no está autenticado se va aquí
unset($_SESSION['guest']); // dejas de ser invitado para que no te mande siempre a home
$page = 'login';  //para que se aplique login.css en login.php
include "app/layouts/header.php";
include "app/layouts/login.php";
include "app/layouts/footer.php";
exit();
