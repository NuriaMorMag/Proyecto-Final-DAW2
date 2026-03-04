<?php

// Comprobar si el usuario puede modificar imágenes
function userCanManageImages() { 
    return isset($_SESSION['user']) && ($_SESSION['user'] === 'Nmm679' || $_SESSION['user'] === 'Smmcl'); 
}

?>