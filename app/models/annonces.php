<?php

function getAnnonces(PDO $conn, int $annonceParPage, int $offset, ?int $categorieId = null)
{
    try {
        $sql = "
        SELECT
            a.photo_annonce,
            a.prix_unitaire_annonce,
            a.titre_annonce,
            a.id_annonce,
            TIMESTAMPDIFF(SECOND, a.date_creation_annonce, NOW()) AS duree_secondes,
            b.nom_boutique,
            b.logo_boutique,
            b.id_boutique,
            s.score_final,
            s.nb_likes,
            s.nb_commandes

        FROM annonces a

        LEFT JOIN boutiques b 
            ON b.id_boutique = a.id_boutique

        LEFT JOIN annonce_stats s
            ON s.id_annonce = a.id_annonce

        WHERE a.quantite_disponible_annonce > 0
        ";

        if ($categorieId !== null) {
            $sql .= " AND a.id_categorie = :categorie ";
        }

        $sql .= "
        ORDER BY 
            s.score_final DESC,
            a.date_creation_annonce DESC
        LIMIT :limit OFFSET :offset
        ";

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':limit', $annonceParPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        if ($categorieId !== null) {
            $stmt->bindValue(':categorie', $categorieId, PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        return $e->getMessage();
    }
}


function getTop20Annonces(PDO $conn)
{
    try {
        $sql = "
        SELECT
            a.photo_annonce,
            a.prix_unitaire_annonce,
            a.titre_annonce,
            a.id_annonce,
            TIMESTAMPDIFF(SECOND, a.date_creation_annonce, NOW()) AS duree_secondes,
            b.nom_boutique,
            b.logo_boutique,
            b.id_boutique,
            s.score_final,
            s.nb_likes,
            s.nb_commandes

        FROM annonces a

        LEFT JOIN boutiques b 
            ON b.id_boutique = a.id_boutique

        LEFT JOIN annonce_stats s
            ON s.id_annonce = a.id_annonce

        WHERE a.quantite_disponible_annonce > 0

        ORDER BY 
            s.score_final DESC,
            a.date_creation_annonce DESC

        LIMIT 20
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        return $e->getMessage();
    }
}



function countAnnonces($conn) {
    $stmt = $conn->query("SELECT COUNT(*) as total FROM annonces");
    return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

function countAnnoncesByCategorie($conn, $categorie){
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM annonces WHERE id_categorie = ?");
    $stmt->execute([$categorie]);
    return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

function createAnnonce($conn, $id_boutique, $title, $quantite, $prix, $urlImage, $urlImage1, $categorie, $description) {
    $stmt = $conn->prepare("
        INSERT INTO annonces (id_boutique, id_categorie, titre_annonce, Quantite_disponible_annonce, Prix_unitaire_annonce, photo_annonce, photo_annonce1, 					description_annonce) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if ($stmt->execute([$id_boutique, $categorie, $title, $quantite, $prix, $urlImage, $urlImage1, $description])) {
        return true;
    }

    return false;
}

function getCategorieBySousCategorie(PDO $conn, int $id): ?int {
    $stmt = $conn->prepare("
        SELECT id_categorie 
        FROM sous_categories 
        WHERE id_sous_categorie = ?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    $result = $stmt->fetchColumn();

    return $result !== false ? (int)$result : null;
}

function getAnnonceInformationByIdAnnonce($conn, $id_annonce){
    $stmt = $conn->prepare("SELECT * FROM annonces WHERE id_annonce = ?");
    $stmt->execute([$id_annonce]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAnnoncesByUserId($conn, $id_utilisateur) {
    $req = $conn->prepare("SELECT * FROM annonces JOIN boutiques b ON annonces.id_boutique = b.id_boutique
	JOIN utilisateurs u ON b.id_utilisateur = u.id_utilisateur WHERE u.id_utilisateur=?");
    $req->execute([$id_utilisateur]);
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

function deleteAnnonceById($conn, $id_annonce){
    $stmt = $conn->prepare("DELETE FROM annonces WHERE id_annonce = ?");
    return $stmt->execute([$id_annonce]);
}

function updateAnnonce($conn, $id_annonce, $titre, $quantite, $prix, $description) {
    $stmt = $conn->prepare("
        UPDATE annonces 
        SET titre_annonce = ?,  Quantite_disponible_annonce = ?, Prix_unitaire_annonce = ?, description_annonce = ?
        WHERE id_annonce = ?
    ");

    return $stmt->execute([$titre, $quantite, $prix, $description, $id_annonce]);
}

function getCategorie(PDO $conn): array{
    $stmt = $conn->prepare("SELECT id_categorie, nom_categorie, data_route_categorie FROM categorie ORDER BY id_categorie ASC LIMIT 6");
    $stmt->execute();    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

}

function getAllCategorie(PDO $conn): array{
    $stmt = $conn->prepare("SELECT id_categorie, nom_categorie, data_route_categorie FROM categorie ORDER BY id_categorie ASC");
    $stmt->execute();    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function recherche(PDO $conn, string $q, ?int $user_id = null): array {

    $sql = "
        SELECT 
            a.*,
            b.nom_boutique,
            b.logo_boutique,
            TIMESTAMPDIFF(SECOND, a.date_creation_annonce, NOW()) AS duree_secondes,
            s.score_final
        FROM annonces a
        JOIN boutiques b 
            ON b.id_boutique = a.id_boutique
       	LEFT JOIN annonce_stats s
        	ON s.id_annonce = a.id_annonce
        WHERE 
            a.quantite_disponible_annonce > 0
            AND a.titre_annonce LIKE :q
        ORDER BY 
        	COALESCE(s.score_final, 0) DESC,
    		a.date_creation_annonce DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'q' => '%' . $q . '%'
    ]);

    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $nb_resultats = count($resultats);

    $sql_recherche = "
        INSERT INTO recherche
        (
            mot_cle,
            user_id,
            resultats,
            ip,
            date_recherche
        )
        VALUES
        (
            :mot_cle,
            :user_id,
            :resultats,
            :ip,
            NOW()
        )
    ";

    $stmt = $conn->prepare($sql_recherche);

    $stmt->execute([
        'mot_cle' => $q,
        'user_id' => $user_id,
        'resultats' => $nb_resultats,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? null
    ]);

    return [
        'total' =>  $nb_resultats,
        'annonces' =>  $resultats
    ];
}



function updateAnnonceStats(PDO $conn): bool
{
    try {

        $sqlKeywords = "
        SELECT mot_cle, COUNT(*) AS total
        FROM recherche
        GROUP BY mot_cle
        ORDER BY total DESC
        LIMIT 50
        ";

        $stmtKeywords = $conn->prepare($sqlKeywords);
        $stmtKeywords->execute();
        $keywords = $stmtKeywords->fetchAll(PDO::FETCH_COLUMN);


        $sql = "
        SELECT 
            a.id_annonce,
            a.titre_annonce,
            a.quantite_disponible_annonce,
            a.trust_score,

            (SELECT COUNT(*) 
             FROM likes l 
             WHERE l.id_annonce = a.id_annonce) AS nb_likes,

            (SELECT COUNT(*) 
             FROM commandes c
             WHERE c.id_annonce = a.id_annonce
             AND c.status_commande = 'produit livré') AS nb_commandes

        FROM annonces a
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($annonces as $a) {

            $likes = (int)$a['nb_likes'];
            $commandes = (int)$a['nb_commandes'];
            $stock = (int)$a['quantite_disponible_annonce'];
            $titre = strtolower($a['titre_annonce']);

            $matchs = 0;

            foreach ($keywords as $kw) {

                $kw = strtolower(trim($kw));

                if ($kw !== "" && strpos($titre, $kw) !== false) {
                    $matchs++;
                }
            }


            $score_recherche = 1 - exp(-$matchs / 3);


            $score_likes = 1 - exp(-$likes / 10);

            $score_commandes = 1 - exp(-$commandes / 5);

            $score_stock = 1 - exp(-$stock / 20);


            $score_final = (
                ($score_commandes * 0.40) +
                ($score_likes * 0.20) +
                ($score_recherche * 0.20) +
                ($score_stock * 0.10)
            );

            $score_final = ($score_final * 0.6) + ((int)$a['trust_score'] * 0.4);


            $sqlUpdate = "
            INSERT INTO annonce_stats (
                id_annonce,
                nb_likes,
                nb_commandes,
                score_likes,
                score_commandes,
                score_recherche,
                score_stock,
                score_final,
                date_calcul
            )
            VALUES (
                :id_annonce,
                :likes,
                :commandes,
                :score_likes,
                :score_commandes,
                :score_recherche,
                :score_stock,
                :score_final,
                NOW()
            )
            ON DUPLICATE KEY UPDATE
                nb_likes = VALUES(nb_likes),
                nb_commandes = VALUES(nb_commandes),
                score_likes = VALUES(score_likes),
                score_commandes = VALUES(score_commandes),
                score_recherche = VALUES(score_recherche),
                score_stock = VALUES(score_stock),
                score_final = VALUES(score_final),
                date_calcul = NOW()
            ";

            $update = $conn->prepare($sqlUpdate);

            $update->execute([
                ':id_annonce' => $a['id_annonce'],
                ':likes' => $likes,
                ':commandes' => $commandes,
                ':score_likes' => $score_likes,
                ':score_commandes' => $score_commandes,
                ':score_recherche' => $score_recherche,
                ':score_stock' => $score_stock,
                ':score_final' => $score_final
            ]);
        }

        return true;

    } catch (PDOException $e) {

        echo json_encode([
            "success" => false,
            "messsage" => "Erreur SQL :" . $e->getMessage()
        ]) ;
        return false;
    }
}

function getAnnonceWithOwner(PDO $conn, int $id_annonce, int $id_user) {

    $sql = "
        SELECT a.*
        FROM annonces a
        JOIN boutiques b ON a.id_boutique = b.id_boutique
        WHERE a.id_annonce = :id_annonce
        AND b.id_utilisateur = :id_user
        LIMIT 1
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'id_annonce' => $id_annonce,
        'id_user' => $id_user
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}


?>


