<?php

require_once __DIR__ . '/../models/annonces.php';

function viewmyproductpagecontroller(PDO $conn){

    if (!isset($_SESSION['id'])) {
        header('location: index.php?page=connexion');
        exit();
    }
    
    function formatMoney($amount) {
    return number_format($amount, 0, '', '.');
    }
    
    $annonces = getAnnoncesByUserId($conn, $_SESSION['id']);   

    require_once __DIR__ . '/../../views/viewmyproduct.php';

}

?>