<?php

function getLikesByUser($conn, $userId) {
    $stmt = $conn->prepare("SELECT id_annonce FROM likes WHERE id_utilisateur = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProduitById($conn, $idProduit) {
    $stmt = $conn->prepare("SELECT * FROM annonces WHERE id_annonce = ? AND quantite_disponible_annonce > 0");
    $stmt->execute([$idProduit]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>