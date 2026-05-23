<?php

require __DIR__ . '/../models/boutiques.php';
require __DIR__ . '/../controllers/boutique.php';
require_once __DIR__ . '/../models/annonces.php';

function creerboutique(PDO $conn){
    
    if (!isset($_SESSION['id'])) {
        header('Location: /connexion');
        exit;
    }

    $categories = getCategorie($conn);

    $status = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = createBoutiqueController($conn, $_POST, $_FILES);
    if (!empty($status['urlBoutique'])) {
        header('Location: ' . $status['urlBoutique']);
        exit;
    }

    }

    require_once __DIR__ . '/../../views/creermaboutique.php';

}

?>