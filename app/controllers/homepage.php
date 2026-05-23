<?php
    
require_once __DIR__ . '/../models/annonces.php';

function homepagecontroller($conn){
    $categories = getCategorie($conn);
    require_once __DIR__ . '/../../views/homepage.php';
}

?>