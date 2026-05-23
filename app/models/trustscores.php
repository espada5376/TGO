<?php
    
function getAnnoncesForTrustscore(PDO $conn): array {
    $stmt = $conn->query("
        SELECT 
        id_annonce, 
        titre_annonce, 
        description_annonce, 
        photo_annonce,
        photo_annonce1,
        date_creation_annonce
        FROM annonces
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function updateAnnonceTrustscore(PDO $conn, int $idAnnonce, int $score): void {
    $stmt = $conn->prepare("UPDATE annonces SET trust_score = :score WHERE id_annonce = :id");
    $stmt->execute([
        'score' => $score,
        'id'    => $idAnnonce
    ]);
}


function markAnnonceAsChecked(PDO $conn, int $id_annonce){
    $stmt = $conn->prepare("UPDATE annonces SET verifier = 1 WHERE id_annonce = :id");
    $stmt->execute([
        'id' => $id_annonce
    ]);
}

?>