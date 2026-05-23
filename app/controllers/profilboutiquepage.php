<?php

require_once __DIR__ . '/../models/boutiques.php';
require_once __DIR__ . '/../controllers/boutique.php';

function profilboutiquepagecontroller(PDO $conn){
    
    $boutique = null;
    $interval = null;
    $annonces = null;
	
    function formatMoney($amount) {
    return number_format($amount, 0, '', '.');
	}
        
    $boutiqueinfo = afficherBoutique($conn);

    if($boutiqueinfo['success']){
        $boutique = $boutiqueinfo['boutique'];
        $interval = $boutiqueinfo['anciennete'];
        $annonces = $boutiqueinfo['produits'];
    }
        
    $baseUrl = 'https://tg.infinityfreeapp.com';
	$image = $baseUrl . '/assets/logo_boutique/' . $boutique['logo_boutique'];
	$url   = $baseUrl . '/index.php?page=profilboutique&id=' . $boutique['id_boutique'];
    


    require_once __DIR__ . '/../../views/profilboutique.php';  

}

    
?>