<?php


require __DIR__ . '/../models/boutiques.php';
require __DIR__ . '/../controllers/boutique.php';

function infocomptepagecontroller(PDO $conn){
    
    if (!isset($_SESSION['id'])) {
        header('Location: index.php?page=connexion');
        exit;
    }

    $boutique = getBoutique($conn, $_SESSION['id']);

    $status = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = createBoutiqueController($conn, $_POST, $_FILES);
    }

    require_once __DIR__ . '/../../views/infoCompte.php';

}

?>