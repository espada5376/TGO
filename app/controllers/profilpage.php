<?php

require_once __DIR__ . '/../models/boutiques.php';


function profilpagecontroller(PDO $conn){
    
    if (!isset($_SESSION['id'])) {
        header('Location: index.php?page=connexion');
        exit;
    }

    $hasBoutique = getBoutique($conn, $_SESSION['id']);

    require_once __DIR__ . '/../../views/profil.php';
}




?>