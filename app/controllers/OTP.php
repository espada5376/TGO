<?php


function sendOTP(PDO $conn): void
{
    header('Content-Type: application/json');
    
        $input = json_decode(file_get_contents("php://input"), true);

    if (!$input) {
        echo json_encode([
            "success" => false,
            "message" => "Données invalides"
        ]);
        return;
    }

    $tel_client_commande = $input['tel'];
    $_SESSION['tel_client_commande'] = $tel_client_commande;
    
        if (isset($_SESSION['id']) && !isset($input['cBoutique']) ) {
        echo json_encode([
            'success' => true,
            'message' => 'Utilisateur connecté, envoi OTP non requis'
        ]);
        exit();
    }

    if (!$tel_client_commande) {
        echo json_encode([
            'success' => false,
            'message' => 'Téléphone client introuvable'
        ]);
        exit();
    }


    $otp = createOTP($conn, $tel_client_commande);
    $message_otp = OTPTemplate($otp);

    $_SESSION['otp'] = $otp;
    $_SESSION['otp_phone'] = $tel_client_commande;
    $_SESSION['otp_created_at'] = time();

    $response = sendWhatsAppMessage($tel_client_commande, $message_otp);

if ($response['status'] === 201) {
    echo json_encode([
        'success' => true,
        'message' => 'OTP envoyé avec succès. Vérifiez votre WhatsApp.'
    ]);
    exit();
} else {
    DeleteOTP($conn, $tel_client_commande);
    echo json_encode([
        'success' => false,
        'message' => 'Échec de l\'envoi de l\'OTP',
        'details' => $response['provider_response']
    ]);
    exit();   
}
}


function verifyOtp($conn){

    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);
    $inputOTP = $input['otp'] ?? '';

    $otpRecord = getOTP($conn, $_SESSION['tel_client_commande']);

    if( !$otpRecord ) {
        jsonResponse(false, 'Aucun OTP valide trouvé pour ce numéro.');
    }

    if ($otpRecord['minutes_passé'] > 5) {
        jsonResponse(false, 'OTP expiré');
    }

    if (!password_verify($inputOTP, $otpRecord['otp_hash'])) {
        if(DeleteOTP($conn, $_SESSION['tel_client_commande']) === false){
        jsonResponse(false, 'OTP incorrect. veillez réessayer.');
        }
    }

    if(DeleteOTP($conn, $_SESSION['tel_client_commande']) === false){
        jsonResponse(false, 'Échec de la suppression de l\'OTP.');
    }

    unset($_SESSION['tel_client_commande']);
    $_SESSION['otp_verified'] = true;
    
    jsonResponse(true, 'OTP vérifié avec succès!');

}


function OTPTemplate($code){
    return
"*Code de vérification*

Votre code est : *{$code}*
    
⚠️ Ne le partagez avec personne.

_TogoMarket_";
}

?>
