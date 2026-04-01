<?php

// Check if the user can modify images
function userCanManageImages() { 
    return isset($_SESSION['user']) && ($_SESSION['user'] === 'Nmm679' || $_SESSION['user'] === 'Smmcl'); 
}


// Functions for image optimization

/**
 * Compress an image keeping the same pixel size,
 * but reducing the file size (quality)
 *
 * $source - path to the original image file
 * $destination - path where the compressed version will be saved
 * $quality - quality (0–100), 80 is usually a good balance
 */
function compressImage($source, $destination, $quality = 80) {
    $info = getimagesize($source); // get basic image info (type, width, height, etc.)

    if ($info['mime'] === 'image/jpeg') {
        $image = imagecreatefromjpeg($source);   // Create an image resource from a JPEG file
        imagejpeg($image, $destination, $quality); // Save the JPEG image with the given quality
    } elseif ($info['mime'] === 'image/png') {
        $image = imagecreatefrompng($source);    // Create an image resource from a PNG file
        // For PNG, compression goes from 0 (no compression) to 9
        imagepng($image, $destination, 6);      
    } else {
        // If it is not JPG or PNG, do nothing
        return false;
    }
    return true;
}

/**
 * Create a thumbnail by reducing the image size in pixels
 *
 * $source - path to the original image
 * $destination - path where the thumbnail will be saved
 * $maxWidth - maximum width of the thumbnail (height is calculated proportionally)
 */
function createThumbnail($source, $destination, $maxWidth = 600) {
    // Get original image size and info
    $info = getimagesize($source);
    list($width, $height) = $info; // original width and height

    // Calculate aspect ratio to keep the same shape 
    $ratio = $width / $height;
    $newWidth = $maxWidth;
    $newHeight = $maxWidth / $ratio; // Calculate the new height so that the image doesn't become distorted

    // Create a new empty image (canvas) with the reduced size to later paste the compress version
    $thumb = imagecreatetruecolor($newWidth, $newHeight);

    // Load the original image depending on its type
    if ($info['mime'] === 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] === 'image/png') {
        $image = imagecreatefrompng($source);
    } else {
        // If it is not JPG or PNG, stop
        return false;
    }

    // Copy and resize the original image into the new canvas
    imagecopyresampled(
        $thumb, $image,
        0, 0, 0, 0,
        $newWidth, $newHeight,
        $width, $height
    );

    // Save the thumbnail as a JPEG with quality 80
    imagejpeg($thumb, $destination, 80);
    return true;
}

/**
 * Convert a JPG or PNG image to WebP format.
 *
 * $source - path to the original image
 * $destination - path where the WebP version will be saved
 * $quality - quality (0–100)
 */
function convertToWebP($source, $destination, $quality = 80) {
    // Get info about the image (including its MIME type)
    $info = getimagesize($source);

    if ($info['mime'] === 'image/jpeg') {
        // Load JPEG image
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] === 'image/png') {
        // Load PNG image
        $image = imagecreatefrompng($source);
    } else {
        // If it is not JPG or PNG, do not convert
        return false;
    }

    // Save the image as WebP with the given quality
    imagewebp($image, $destination, $quality);
    return true;
}

?>