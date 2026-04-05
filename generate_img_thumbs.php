<?php
set_time_limit(0);
require_once "app/functions.php"; 

$dir = "web/img/";
$thumbDir = "web/img/thumbs/";
$webpDir = "web/img/webp/";
$thumbWebpDir = "web/img/webp/thumbs/";

$files = scandir($dir);

foreach ($files as $file) {

    if ($file === "." || $file === "..") continue;

    $path = $dir . $file;

    // Skip folders
    if (is_dir($path)) continue;

    // Only process images JPG/PNG
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (!in_array($ext, ["jpg", "jpeg", "png"])) continue;

    echo "<strong>Processing:</strong> $file<br>";

    // Destunarion routes
    $thumbPath = $thumbDir . $file;
    $webpPath = $webpDir . pathinfo($file, PATHINFO_FILENAME) . ".webp";
    $thumbWebpPath = $thumbWebpDir . pathinfo($file, PATHINFO_FILENAME) . ".webp";

    // THUMB
    if (!file_exists($thumbPath)) {
        createThumbnail($path, $thumbPath, 600);
        echo "✔ Miniatura creada<br>";
    } else {
        echo "— Miniatura ya existía, saltada<br>";
    }

    // WEBP ORIGINAL
    if (!file_exists($webpPath)) {
        convertToWebP($path, $webpPath, 80);
        echo "✔ WebP original creado<br>";
    } else {
        echo "— WebP original ya existía, saltado<br>";
    }

    // WEBP THUMB
    if (!file_exists($thumbWebpPath)) {
        convertToWebP($thumbPath, $thumbWebpPath, 70);
        echo "✔ WebP miniatura creado<br>";
    } else {
        echo "— WebP miniatura ya existía, saltado<br>";
    }

    echo "<br>";
}

echo "<h2>Proceso completado</h2>";