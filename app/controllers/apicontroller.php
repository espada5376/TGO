<?php

function apicontroller(PDO $conn, string $action){


header('Content-Type: application/json; charset=utf-8');

    $action = preg_replace('/[^a-zA-Z0-9_]/', '', $action);

    switch ($action) {

        case 'chargerannonce':
            require_once __DIR__ . '/../routes/chargerAnnonces.php';
            break;

        case 'applylike':
            require_once __DIR__ . '/../routes/applylike.php';
            break;            

        case 'addlike':
            require_once __DIR__ . '/../routes/addlike.php';
            break;

        case 'commande':
            require_once __DIR__ . '/../routes/commande.php';
            break;

        case 'delete':
            require_once __DIR__ . '/../routes/delete-annonce.php';
            break;

        case 'listecommandes':
            require_once __DIR__ . '/../routes/listecommandes.php';
            break;
        
        case 'listecommandesboutique':
            require_once __DIR__ . '/../routes/listecommandesboutique.php';
            break;

        case 'notifications':
            require_once __DIR__ . '/../routes/notifications.php';
            break;

        case 'updatenotification':
            require_once __DIR__ . '/../routes/updateNotification.php';
            break;

        case 'updateDelivery':
            require_once __DIR__ . '/../routes/updateDelivery.php';
            break;

        case 'saveToken':
            require_once __DIR__ . '/../routes/sendToken.php';
            break;

        case 'otp':
            require_once __DIR__ . '/../routes/OTP.php';
            break;

        case 'verifyOTP':
            require_once __DIR__ . '/../routes/verifyOTP.php';
            break;
            
            
        case 'uimetrics':
            require_once __DIR__ . '/../routes/uimetrics.php';
            break;
            
        case 'search':
            require_once __DIR__ . '/../routes/rechercheProduits.php';
            break;
            
        case 'frais':
            require_once __DIR__ . '/../routes/frais.php';
            break;
         
        default:
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error'   => 'API inconnue'
            ]);
    }

    exit;

}

?>