<?php

function emailOuTelExists($conn, string $email, string $tel): bool {
    $stmt = $conn->prepare("SELECT id_utilisateur FROM utilisateurs WHERE email_utilisateur = ? OR tel_utilisateur = ?");
    $stmt->execute([$email, $tel]);
    return $stmt->rowCount() > 0;
}

function createUser($conn, string $nom, string $email, string $tel, string $password): ?array {
    $passHash = password_hash($password, PASSWORD_DEFAULT);

    $insert = $conn->prepare("INSERT INTO utilisateurs(nom_utilisateur, email_utilisateur, tel_utilisateur, mdp_utilisateur) VALUES(?, ?, ?, ?)");
    $success = $insert->execute([$nom, $email, $tel, $passHash]);

    if ($success) {
        $userId = $conn->lastInsertId();
        $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return null;
}


function findUserByTel($tel, $conn) {
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE tel_utilisateur = ?");
    $stmt->execute([$tel]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function userinfo($conn, $id_utilisateur){
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = ?");
    $stmt->execute([$id_utilisateur]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>


