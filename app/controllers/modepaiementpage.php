<?php

require_once __DIR__ . '/../models/boutiques.php';

require_once __DIR__ . '/../controllers/modepaiement.php';


function modepaiementpagecontroller($conn){

    $id_boutique = getBoutiqueByUser($conn, $_SESSION['id']);
    $paymentMethods = getPaymentMethods($conn);
    
    $boutique_mode_paiement = getBoutiqueModePaiement($conn, $id_boutique);

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$methods = $_POST['payment_methods'] ?? [];
                
        if (!empty($methods) && $id_boutique > 0) {
            $success = addPaymentMethod($conn, $id_boutique, $methods);
            if ($success) {
                $_SESSION['success'] = "Mode de paiement ajoutées avec succès !";
             
            } else {
               	$_SESSION['success'] = "Erreur lors de l'ajout des modes.";
              
            }
        } else {
           	$_SESSION['success'] = "Veuillez sélectionner au moins un mode.";
           
        }
             
}

    require __DIR__ . '/../../views/modepaiement.php';
}






?>