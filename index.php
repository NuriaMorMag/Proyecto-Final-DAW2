<?php

require_once "app/dat/DataAccess.php";
require_once "app/dat/Gallery.php";
require_once "app/functions.php";

session_start();

$message = "";

/* SESSION TIME CONTROL (10 min) 
Before anything else: if the session expires, everything stops
Checks if the user was logged in before ($_SESSION['timeout'] is set in login)
Looks at how much time has passed since the last action
If time is out the session ends and the user is sent back to login
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
    // Every time the user interacts with the page session time is updated
    $_SESSION['timeout'] = time();

    $bd = DataAccess::getModel();


    /* ACTIONS RELATED TO IMAGES (before the page switch) */

    // ADD IMAGE
    if (isset($_REQUEST['order']) && $_REQUEST['order'] === 'addImage') {

        // Check permissions
        if (!userCanManageImages()) {
            die('You don\'t have permission to add images.');
        }

        $page = "addImage";  // so that the corresponding CSS file loads

        include 'app/layouts/header.php';
        include 'app/layouts/addImage.php';
        include 'app/layouts/footer.php';
        exit();
    }

    // SAVE NEW IMAGE  
    if (isset($_REQUEST['order']) && $_REQUEST['order'] === 'saveImage') {

        // Check permissions
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
        // Overwrite the same path ($targetPath): opens the image, compresses it, and saves it to the same file, replacing the original
        compressImage($targetPath, $targetPath, 80);

        // Create a thumbnail (smaller image in pixels for the gallery)
        $thumbPath = "web/img/thumbs/" . $path;
        createThumbnail($targetPath, $thumbPath, 600); // Maximum width of 600px


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

        // Save in DB 
        $bd->addImage($title,  $targetPath, $alt, $category, $date, $commentary, $is_blog);

        header('Location: index.php?page=gallery');

        echo "<pre>";
        print_r($_POST);
        echo "</pre>";

        exit();
    }

    // EDIT IMAGE
    if (isset($_REQUEST['order']) && $_REQUEST['order'] === 'editImage') {

        // Check permissions
        if (!userCanManageImages()) {
            die("You don't have permission to edit images.");
        }

        $page = "editImage"; //  so that the corresponding CSS file loads

        $id = $_GET['id'] ?? NULL;
        if (!$id) {
            die('Image not found.'); // If the ID is empty, 0, NULL, or any false value, stop the process
        }

        $image = $bd->getImageById($id);

        include 'app/layouts/header.php';
        include 'app/layouts/editImage.php';
        include 'app/layouts/footer.php';
        exit();
    }

    // UPDATE IMAGE
    if (isset($_REQUEST['order']) && $_REQUEST['order'] === 'updateImage') {

        // Check permissions
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

        // Update the image in the database
        $bd->updateImage($id, $title, $alt, $category, $date, $commentary, $is_blog);

        header('Location: index.php?page=gallery');
        exit();
    }

    // DELETE IMAGE
    if (isset($_REQUEST['order']) && $_REQUEST['order'] === 'deleteImage') {

        // Check permissions
        if (!userCanManageImages()) {
            die("You don't have permission to delete images.");
        }

        // Get the image ID
        $id = $_GET['id'] ?? null;

        // If the ID exists, delete the image
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
            header("Location: index.php"); // Force a restart while the session is active so that: isset($_SESSION['user'])
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

    // Check empty fields 
    if (empty($name) || empty($login) || empty($email) || empty($password) || empty($password2)) {
        $message = "All fields are required";
        include "app/layouts/header.php";
        include "app/layouts/register.php";
        include "app/layouts/footer.php";
        exit();
    }

    // Check passwords match 
    if ($password !== $password2) {
        $message = "Passwords do not match";
        include "app/layouts/header.php";
        include "app/layouts/register.php";
        include "app/layouts/footer.php";
        exit();
    }

    // Check if login already exists
    $bd = DataAccess::getModel();
    $user = $bd->getUser($login);


    if ($user !== false) {
        $message = "This login is already taken";
        include "app/layouts/header.php";
        include "app/layouts/register.php";
        include "app/layouts/footer.php";
        exit();
    }

    // Create new user
    $newUser = new Userapp(); 
    $newUser->name  = $name;
    $newUser->login = $login;
    $newUser->email = $email;
    $newUser->password = password_hash($password, PASSWORD_DEFAULT);

    // Save user in database
    $bd->addUser($newUser);

    // Iniciar sesión automáticamente 
    $_SESSION['user'] = $newUser->login;
    $_SESSION['name'] = $newUser->name;
    $_SESSION['timeout'] = time();

    // Redirect to home
    header("Location: index.php");
    exit();
}

/* REGISTER FORM */
if (isset($_REQUEST['order']) && $_REQUEST['order'] == "Sign up") {

    $page = 'login'; // so that login.css is applied in register.php

    include "app/layouts/header.php";
    include "app/layouts/register.php";
    include "app/layouts/footer.php";
    exit();
}

/* GUEST LOGOUT (return to the login page from guest mode) */
if (isset($_REQUEST['order']) && $_REQUEST['order'] === 'guest_logout') {
    unset($_SESSION['guest']);  
    header("Location: index.php"); // Return to normal flow: the login screen appear 
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
// If the user is not logged in, they will be redirected here
unset($_SESSION['guest']); // You stop being guest so I don't keep sending you home
$page = 'login';  // so that login.css is applied in login.php
include "app/layouts/header.php";
include "app/layouts/login.php";
include "app/layouts/footer.php";
exit();
