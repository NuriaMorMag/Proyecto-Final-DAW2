<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Shooting Mood | Nuria Moreno</title>
    <meta name="description" content="A photography blog showcasing particular and beautiful moments of people.">
    <meta name="keywords"
        content="photography, portraits, camera, session, photo editing, photography types, photography blog, photo model">
    <meta name="author" content="Nuria Moreno Magaña">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="web/img/favicon.jpg"> <!-- icon in the browser tab -->
    <!--Para ver imagenes bien al clicarlas-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet"> <!-- Archivo CSS de Lightbox en CDN -->

    <!-- Google Fonts: Fuente para títulos y texto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- CSS común -->
    <link rel="stylesheet" href="web/css/style.css?v=12">

    <!-- CSS específico según la vista -->
    <?php if (isset($page)): ?>
        <link rel="stylesheet" href="web/css/<?= $page ?>.css?v=13">
    <?php endif; ?>
</head>

<body>

    <header>
        <nav>
            <ul>
                <!-- Ponemos class="active" según la página en la que esté -->
                <li>
                    <a href="index.php?page=home"
                        class="<?= (isset($page) && $page === 'home') ? 'active' : '' ?>">
                        Home
                    </a>
                </li>
                <li>
                    <a href="<?= isset($_SESSION['guest']) ? '#' : 'index.php?page=gallery' ?>"
                        class="<?= (isset($page) && $page === 'gallery') ? 'active' : '' ?>
                        <?= isset($_SESSION['guest']) ? 'disabled-link' : '' ?>">
                        Gallery
                    </a>
                </li>
                <li>
                    <a href="<?= isset($_SESSION['guest']) ? '#' : 'index.php?page=about' ?>"
                        class="<?= (isset($page) && $page === 'about') ? 'active' : '' ?>
                        <?= isset($_SESSION['guest']) ? 'disabled-link' : '' ?>">
                        About me
                    </a>
                </li>
                <li>
                    <!--Con la almohadilla el enlace queda desactivado-->
                    <a href="<?= isset($_SESSION['guest']) ? '#' : 'index.php?page=contact' ?>"
                        class="<?= (isset($page) && $page === 'contact') ? 'active' : '' ?>
                        <?= isset($_SESSION['guest']) ? 'disabled-link' : '' ?>">
                        Contact
                    </a>
                </li>
                <li>
                    <a href="<?= isset($_SESSION['guest']) ? '#' : 'index.php?page=blog' ?>"
                        class="<?= (isset($page) && $page === 'blog') ? 'active' : '' ?>
                        <?= isset($_SESSION['guest']) ? 'disabled-link' : '' ?>">
                        Blog
                    </a>
                </li>
            </ul>

            <!-- Welcome y Logout solo aparecen si la sesión existe -->
            <?php if (isset($_SESSION['user'])): ?>
                <p class="welcome">Welcome, <?= htmlspecialchars($_SESSION['name']) ?></p>

                <form method="post" class="logout-form">
                    <button type="submit" name="order" value="signout">Sign out</button>
                </form>
            <?php endif; ?>

            <?php if (isset($_SESSION['guest']) && !isset($_SESSION['user'])): ?>
                <form method="post" class="logout-form">
                    <button type="submit" name="order" value="guest_logout">Go to login</button>
                </form>
            <?php endif; ?>

        </nav>
    </header>

    <main class="<?= isset($page) ? $page . '-page' : '' ?> page-container">