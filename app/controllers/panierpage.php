<?php


require_once __DIR__ . '/../models/paniers.php';
require_once __DIR__ . '/../controllers/panier.php';

function panierpagecontroller(PDO $conn){

    if(!isset($_SESSION['id'])){
        header('Location: /connexion');
        exit;
    }
    
    function formatMoney($amount) {
    return number_format($amount, 0, '', '.');
    }

    $state = afficherPanierController($conn);

    $message = $state['message'] ?? null;
    $panier = $state['panier'] ?? ['ids' => [], 'noms' => [], 'photos' => [], 'prix' => []];

    require_once __DIR__ . '/../../views/panier.php';
    
}

?>