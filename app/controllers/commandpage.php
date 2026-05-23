<?php

require_once __DIR__ . '/../models/annonces.php';
require_once __DIR__ . '/../models/likes.php';
require_once __DIR__ . '/../models/boutiques.php';

function commandpagecontroller(PDO $conn){

    $id_annonce = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    $annonce = getAnnonceInformationByIdAnnonce($conn, $id_annonce);
    
    $boutiquename = getBoutiqueName($conn, $annonce['id_boutique']);

    $likes = getLikesAnnonce($conn, $id_annonce);

    $mode_paiement = getBoutiqueModePaiement($conn, $annonce['id_boutique']);
    
    function formatMoney($amount) {
    return number_format($amount, 0, '', '.');
    }
    
	$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
    
    if ($id <= 0) {
        http_response_code(404);
        exit;
    }

    if (!$annonce) {
        http_response_code(404);
        exit;
    }

    $baseUrl = 'https://tg.infinityfreeapp.com';
    $image = $baseUrl . '/assets/product/' . $annonce['photo_annonce'];
    $url   = $baseUrl . '/index.php?page=command&id=' . $id;
    
	require_once __DIR__ . '/../../views/command.php';

}    

?>