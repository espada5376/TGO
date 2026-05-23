<?php



function registerCommande(
    PDO $conn,
    int $id_boutique,
    int|null $id_client_utilisateur,
    int $id_annonce,
    string $nom_client_commande,
    string $tel_client_commande,
    int $quantite_commande,
    string $mode_paiement_commande,
    ?string $instruction_commande,
    string $status_commande,
    float $longitude_client_commande,
    float $latitude_client_commande
): int|false {

    $stmt = $conn->prepare("
        INSERT INTO commandes (
            id_boutique,
            id_client_utilisateur,
            id_annonce,
            nom_client_commande,
            tel_client_commande,
            quantite_commande,
            mode_paiement_commande,
            instruction_commande,
            status_commande,
            longitude_client_commande,
            latitude_client_commande
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $success = $stmt->execute([
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
    ]);

    if (!$success) {
        return false;
        exit;
    }

    return (int) $conn->lastInsertId(); 
}



function getIdBoutiqueByAnnonce($conn, int $id_annonce){
    $stmt = $conn->prepare("SELECT id_boutique FROM annonces WHERE id_annonce = ?");
    $stmt->execute([$id_annonce]);
    $id_boutique = $stmt->fetchColumn();
    return $id_boutique !== false ? (int)$id_boutique : 0;
}

function updateQuantity($conn, $quantite_commande, $id_annonce){
    $stmt = $conn->prepare("UPDATE annonces SET quantite_disponible_annonce = quantite_disponible_annonce - ? WHERE id_annonce = ?");
    return $stmt->execute([$quantite_commande, $id_annonce]);
}

function getIdSellerByBoutique($conn, $id_boutique){
    $stmt = $conn->prepare("SELECT id_utilisateur FROM boutiques WHERE id_boutique = ?");
    $stmt->execute([$id_boutique]);
    $id_seller = $stmt->fetchcolumn();
    return $id_seller !== false ? (int)$id_seller : 0;
}


function getUserCommandes(PDO $conn, int $id_utilisateur, string $status): array{ 
    $stmt = $conn->prepare("SELECT c.id_annonce,
    c.client_validation_commande,
    c.livreur_validation_commande,
    c.id_commande,
    c.status_commande,
    a.titre_annonce,
    a.date_creation_annonce,
    a.photo_annonce,
    b.nom_boutique,
    b.id_boutique,
    c.quantite_commande, TIMESTAMPDIFF(SECOND, a.date_creation_annonce, NOW()) AS duree_secondes,
    TIMESTAMPDIFF(SECOND, c.date_commande, NOW()) AS duree_secondesc,
    l.tel_livreur
    FROM commandes AS c
	INNER JOIN annonces AS a 
    ON c.id_annonce = a.id_annonce INNER JOIN boutiques AS b 
    ON c.id_boutique = b.id_boutique LEFT JOIN livreurs AS l
    ON c.id_livreur = l.id_livreur WHERE c.id_client_utilisateur = ? AND c.status_commande = ? ORDER BY c.date_commande DESC");
    $stmt->execute([$id_utilisateur, $status]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllCommandes(PDO $conn, int $id_boutique, string $status): array{ 
    $stmt = $conn->prepare("SELECT 
    c.id_annonce,
    b.nom_boutique,
    a.titre_annonce,
    a.date_creation_annonce,
    a.photo_annonce,
    a.prix_unitaire_annonce,
    c.quantite_commande,
    c.mode_paiement_commande,
    c.nom_client_commande,
    TIMESTAMPDIFF(SECOND, a.date_creation_annonce, NOW()) AS duree_secondes,
    TIMESTAMPDIFF(SECOND, c.date_commande, NOW()) AS duree_secondesc
	FROM commandes AS c
	INNER JOIN annonces AS a 
    ON c.id_annonce = a.id_annonce
	INNER JOIN boutiques AS b 
    ON c.id_boutique = b.id_boutique
	WHERE 
    c.id_boutique = ?
    AND c.status_commande = ?
	ORDER BY c.date_commande DESC
	");
    $stmt->execute([$id_boutique, $status]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}

function updateDeliveryStatutM($conn, $id_commande){
    $stmt = $conn->prepare("UPDATE commandes SET client_validation_commande = 1 WHERE id_commande = ?");
    return $stmt->execute([$id_commande]);
    
}

function getCommandeInfo(PDO $conn, int $id_commande): array
{
    $stmt = $conn->prepare("
        SELECT
            c.id_commande,
            c.status_commande,
            c.quantite_commande,
            c.mode_paiement_commande,
            c.nom_client_commande,
            c.tel_client_commande,
            c.id_client_utilisateur,
            c.instruction_commande,
            c.date_commande,

            a.id_annonce,
            a.titre_annonce,
            a.prix_unitaire_annonce,
            a.photo_annonce,
            a.quantite_disponible_annonce
        FROM commandes c
        INNER JOIN annonces a 
            ON c.id_annonce = a.id_annonce
        WHERE c.id_commande = ?
        LIMIT 1
    ");

    $stmt->execute([$id_commande]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>
