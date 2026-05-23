<?php

function getBoutiqueName($conn, $id_boutique){
    $stmt = $conn->prepare("SELECT nom_boutique FROM boutiques WHERE id_boutique = ?");
    $stmt->execute([$id_boutique]);
    return $stmt->fetchColumn();
}

function getBoutique($conn, $id_utilisateur){
    $stmt = $conn->prepare("SELECT * FROM boutiques WHERE id_utilisateur = ?");
    $stmt->execute([$id_utilisateur]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


function createBoutiqueModel($conn, $id_utilisateur, $nom,	$btel,	$longitude, $latitude, $filePath, $categorie, $quartier) {
    $stmt = $conn->prepare(
    "INSERT INTO boutiques(id_utilisateur, nom_boutique, tel_boutique, longitude_boutique, latitude_boutique, logo_boutique, id_categorie, quartier_boutique) VALUES 	(?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt->execute([$id_utilisateur, $nom,	$btel,	$longitude, $latitude, $filePath, $categorie, $quartier])) {
        return $conn->lastInsertId();
        exit();
    }

    return false;
}

function getBoutiqueById($conn, $id) {
    $stmt = $conn->prepare("SELECT 
    *,
    c.nom_categorie AS categorie_boutique,
    TIMESTAMPDIFF(SECOND, date_creation_boutique, NOW()) AS duree_secondes
	FROM boutiques
	JOIN categorie c 
    ON c.id_categorie = boutiques.id_categorie
	WHERE id_boutique = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getBoutiqueByUser($conn, $iduser) {
    $stmt = $conn->prepare("SELECT id_boutique FROM boutiques WHERE id_utilisateur = ?");
    $stmt->execute([$iduser]);
    $id_boutique = $stmt->fetchColumn();
    return $id_boutique !== false ? (int)$id_boutique : null;
}

function getUserByBoutique(PDO $conn, int $id_boutique): ?int
{
    $stmt = $conn->prepare("
        SELECT id_utilisateur 
        FROM boutiques 
        WHERE id_boutique = ?
        LIMIT 1
    ");
    
    $stmt->execute([$id_boutique]);
    $id_user = $stmt->fetchColumn();

    return $id_user !== false ? (int)$id_user : null;
}


function getProduitsByBoutiqueId(PDO $conn, int $idBoutique): array
{
    $sql = "
        SELECT a.*
        FROM annonces a
        INNER JOIN boutiques b ON b.id_boutique = a.id_boutique
        WHERE b.id_boutique = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$idBoutique]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getBoutiqueSousCategorie(PDO $conn, int $id_boutique): array {

    $sql = "
        SELECT 
            s.nom_sous_categorie,
            s.id_sous_categorie
        FROM sous_categories s
        JOIN boutiques b 
            ON b.id_categorie = s.id_categorie
        WHERE b.id_boutique = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_boutique]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addBoutiqueModePaiement(PDO $conn, int $id_boutique, array $modes_paiement): bool {
    if (empty($modes_paiement)) {
        return false; 
    }

    try {
        $conn->beginTransaction();

        $sql = "INSERT INTO boutique_mode_paiement (id_boutique, id_mode_paiement)
                VALUES (:id_boutique, :id_mode_paiement)
                ON DUPLICATE KEY UPDATE id_mode_paiement = id_mode_paiement";

        $stmt = $conn->prepare($sql);

        foreach ($modes_paiement as $id_mode_paiement) {
            
            $stmt->execute([
                ':id_boutique' => $id_boutique,
                ':id_mode_paiement' => (int)$id_mode_paiement
            ]);
        }

        $conn->commit();
        return true;

    } catch (PDOException $e) {
        $conn->rollBack();
        error_log("Erreur addBoutiqueModePaiement: " . $e->getMessage());
        return false;
    }
}

function getBoutiqueModePaiement(PDO $conn, int $id_boutique): array {
    $sql = "
        SELECT mp.* 
        FROM mode_paiement mp
        JOIN boutique_mode_paiement bmp ON mp.id_mode_paiement = bmp.id_mode_paiement
        WHERE bmp.id_boutique = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_boutique]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPaymentMethods(PDO $conn): array {
    $sql = "SELECT * FROM mode_paiement ORDER BY id_mode_paiement";

    $stmt = $conn->query($sql);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>


