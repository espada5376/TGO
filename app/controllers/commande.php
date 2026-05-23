<?php

function registerCommandeController(PDO $conn)
{
    header("Content-Type: application/json");
    
    $isLoggedIn = !empty($_SESSION['id']);

	if (!$isLoggedIn) {
        if (empty($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
            echo json_encode([
                "success" => false,
                "message" => "Vérification OTP requise"
            ]);
            return;
        }
	}

    $input = json_decode(file_get_contents("php://input"), true);

    if (!$input) {
        echo json_encode([
            "success" => false,
            "message" => "Données invalides"
        ]);
        return;
    }

    $id_annonce = $input['idannonce'] ?? null;
    $tel_client_commande = $input['tel'] ?? null;
    $quantite_commande = $input['quantite'] ?? null;
    $mode_paiement_commande = $input['mode_paiement'] ?? null;
    $instruction_commande = $input['instruction'] ?? null;
    $longitude_client_commande = $input['longitude'] ?? null;
    $latitude_client_commande = $input['latitude'] ?? null;
    $nom_client_commande = $input['nom'] ?? null;
    
    if (
        !$id_annonce || !$tel_client_commande || !$quantite_commande ||
        !$mode_paiement_commande || !$longitude_client_commande || !$latitude_client_commande
    ) {
        echo json_encode([
            "success" => false,
            "message" => "Champs obligatoires manquants"
        ]);
        return;
    }

    $id_boutique = getIdBoutiqueByAnnonce($conn, $id_annonce);
    $id_client_utilisateur = $_SESSION['id'] ?? null;

    $status_commande = 'nouvelle commande';

    $id_commande = registerCommande(
        $conn,
        $id_boutique,
        $id_client_utilisateur,
        $id_annonce,
        $nom_client_commande,
        $tel_client_commande,
        $quantite_commande,
        $mode_paiement_commande,
        $instruction_commande,
        $status_commande,
        $longitude_client_commande,
        $latitude_client_commande
    );

    if (!$id_commande) {
        echo json_encode([
            "success" => false,
            "message" => "Échec lors de l'enregistrement"
        ]);
        return;
    }
    
    updateQuantity($conn, $quantite_commande, $id_annonce);
    $commande = getCommandeInfo($conn, $id_commande);
    $id_seller = getUserByBoutique($conn, $id_boutique); 
    
    if($isLoggedIn){
    setNotification(
    $conn,
    $_SESSION['id'],              // acheteur
    'acheteur',
    'commande_acheteur',
    $commande['id_commande']   // référence = commande
);
}
    
   
setNotification(
    $conn,
    $id_seller,              // vendeur
    'vendeur',
    'commande_vendeur',
    $commande['id_commande']     // référence = commande
);

    echo json_encode([
        "success" => true,
        "message" => "Commande enregistrée avec succès"
    ]);
}


function listUserCommandes(PDO $conn): void
{
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        jsonResponse(false, 'Méthode non autorisée');
        exit();
    }

    if (!isset($_SESSION['id'])) {
        header('Location: index.php?page=connexion');
        exit();
    }

    $status = $_GET['status'];
    $utilisateurId = (int)$_SESSION['id'];

    $commandes = getUserCommandes($conn, $utilisateurId, $status);

    $message = empty($commandes)
        ? 'Aucune commande reçue'
        : 'Commandes trouvées';

    jsonResponse(true, $message, $commandes);
}

function listBoutiqueCommandes(PDO $conn): void{ 
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        jsonResponse(false, 'Méthode non autorisée');
        exit();
    }

    if (!isset($_SESSION['id'])) {
        jsonResponse(false, 'Veillez vous connecter');
        exit();
    }

    $status = $_GET['status'];
    $utilisateurId = (int)$_SESSION['id'];

    $id_boutique = getBoutiqueByUser($conn, $utilisateurId);

    $commandes = getAllCommandes($conn, $id_boutique, $status);

    $message = empty($commandes)
        ? 'Aucune commande reçue'
        : 'Commandes trouvées';

    jsonResponse(true, $message, $commandes);
}


function updateDeliveryStatut(PDO $conn){
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        jsonResponse(false, 'Méthode non autorisée');
        return;
    }

    if (!isset($_SESSION['id'])) {
        jsonResponse(false, 'Veillez vous connecter');
        exit();
    }

    $input = json_decode(file_get_contents("php://input"), true);

    $id_commande = $input['id_commande'];

    $commandeValidationClient = updateDeliveryStatutM($conn, $id_commande);

    if($commandeValidationClient){
        jsonResponse(true, 'Livraison valider, Merci pour votre fidéliter');
    }

    jsonResponse(false, 'veillez reéssayer');
}


function getFraisRetrait(array $tarifsRetrait): ?int
{
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        jsonResponse(false, 'Méthode non autorisée');
        exit;
    }
    
   	$input = json_decode(file_get_contents("php://input"), true);

    if (!$input) {
        echo json_encode([
            "success" => false,
            "message" => "Données invalides"
        ]);
        exit;
    }
    
    $montant = $input['montant'];
    
    
    foreach ($tarifsRetrait as $tranche) {
        if ($montant >= $tranche['min'] && $montant <= $tranche['max']) {
            jsonResponse(true, '', $tranche['frais']);
        }
}

    	jsonResponse(true, '', null);
}

function getFraisRetraitR(int $montant, array $tarifsRetrait): int
{
    foreach ($tarifsRetrait as $tranche) {
        if ($montant >= $tranche['min'] && $montant <= $tranche['max']) {
            return $tranche['frais'];
        }
    }

    return 0;
}






?>