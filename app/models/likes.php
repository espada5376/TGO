<?php

function hasLiked($conn, $user_id, $produit_id) {
    $stmt = $conn->prepare("SELECT * FROM likes WHERE id_annonce = ? AND id_utilisateur = ?");
    $stmt->execute([$produit_id, $user_id]);
    return $stmt->rowCount() > 0;
}

function addLike($conn, $user_id, $produit_id) {
    $stmt = $conn->prepare("INSERT INTO likes (id_annonce, id_utilisateur) VALUES (?, ?)");
    $stmt->execute([$produit_id, $user_id]);
}

function removeLike($conn, $user_id, $produit_id) {
    $stmt = $conn->prepare("DELETE FROM likes WHERE id_annonce = ? AND id_utilisateur = ?");
    $stmt->execute([$produit_id, $user_id]);
}

function getLikes($conn, $user_id) {
    $stmt = $conn->prepare("
        SELECT id_annonce
        FROM likes
        WHERE id_utilisateur = ?
    ");
    $stmt->execute([$user_id]);
    $likes = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return [
        'total' => count($likes),
        'id_annonce' => $likes
    ];
}


function getLikesAnnonce($conn, $id_annonce) {
    $stmt = $conn->prepare("
        SELECT id_utilisateur
        FROM likes
        WHERE id_annonce = ?
    ");
    $stmt->execute([$id_annonce]);
    $likes = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return [
        'total' => count($likes),
    ];
}
?>