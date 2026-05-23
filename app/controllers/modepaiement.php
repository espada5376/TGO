<?php

function addPaymentMethod(PDO $conn, int $id_boutique, array $id_mode_paiement): bool {
    
    if (empty($id_mode_paiement)) {
        return false;
    }

    $success = addBoutiqueModePaiement($conn, $id_boutique, $id_mode_paiement);
    return $success;
    
    header("Location: /modepaiement");
    exit();
}

?>