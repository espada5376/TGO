<?php

function boutique($conn) {
    if (empty($_SESSION['id'])) {
        header('Location: /connexion');
        exit;
    }

    $id_utilisateur = $_SESSION['id'];
    return getBoutique($conn, $id_utilisateur);
}


function createBoutiqueController(PDO $conn, array $post, array $files)
{
    if (empty($_SESSION['id'])) {
        header('Location: /connexion');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return null;
    }

    try {
        $id_utilisateur = (int) $_SESSION['id'];
        $nom        = trim($post['nom'] ?? '');
        $quartier   = trim($post['adresse'] ?? '');
        $categorie  = trim($post['categorie'] ?? '');
        $btel       = trim($post['btel'] ?? '');

        $longitude  = isset($post['longitude']) ? (float) $post['longitude'] : null;
        $latitude   = isset($post['latitude']) ? (float) $post['latitude'] : null;

        $logo = $files['logo_boutique'] ?? null;

        if (
            $nom === '' || $quartier === '' || $categorie === '' || $btel === '' ||
            !$logo || empty($logo['name']) || $longitude === null || $latitude === null
        ) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Données manquantes ou invalides'
            ];
            header('Location: /creer-boutique');
            exit;
        }

        $allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize = 2 * 1024 * 1024;

        if (
            !in_array(mime_content_type($logo['tmp_name']), $allowedMime) ||
            $logo['size'] > $maxSize
        ) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Format ou taille de logo non autorisé'
            ];
            header('Location: /creer-boutique');
            exit;
        }

        $extension = pathinfo($logo['name'], PATHINFO_EXTENSION);
        $filenameunique = uniqid('logo_', true) . '.' . $extension;

        $uploadDir = __DIR__ . '/../../assets/logo_boutique/';
        $filePath  = $uploadDir . $filenameunique;

        if (!move_uploaded_file($logo['tmp_name'], $filePath)) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Erreur lors de l’upload du logo'
            ];
            header('Location: /creer-boutique');
            exit;
        }

        $lastId = createBoutiqueModel(
            $conn,
            $id_utilisateur,
            $nom,
            $btel,
            $longitude,
            $latitude,
            $filenameunique,
            $categorie,
            $quartier
        );

        if (!$lastId) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Impossible de créer la boutique'
            ];
            header('Location: /creer-boutique');
            exit;
        }

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Boutique créée avec succès'
        ];

        header('Location: ' . url('profilboutique/' . $lastId));
        exit;

    } catch (Throwable $e) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => 'Erreur serveur'
        ];
        header('Location: /creer-boutique');
        exit;
    }
}


function afficherBoutique(PDO $conn): array
{
    if (!isset($_GET['id'])) {
        header("Location: /");
        exit;
    }

    $idBoutique = (int) $_GET['id'];

    $boutique = getBoutiqueById($conn, $idBoutique);
    if (!$boutique) {
        return [
            'success' => false,
            'message' => 'Boutique introuvable'
        ];
    }

    $produits = getProduitsByBoutiqueId($conn, $idBoutique);
	
   
    $interval = floor($boutique['duree_secondes'] / 86400);
    

    return [
        'success'   => true,
        'boutique'  => $boutique,
        'produits'  => $produits,
        'anciennete'=> $interval
    ];
}

?>
