<?php


function listeAnnonce(PDO $conn)
{
    header("Content-Type: application/json");

    $annonceParPage = 2;
    $page = isset($_GET['pagination']) ? max((int)$_GET['pagination'], 1) : 1;

    $slug = isset($_GET['categorie']) ? trim($_GET['categorie']) : null;

    $categorieId = null;
    if ($slug && $slug !== 'tous') { 
        $stmt = $conn->prepare("SELECT id_categorie FROM categorie WHERE data_route_categorie = :slug");
        $stmt->execute(['slug' => $slug]);
        $categorieId = $stmt->fetchColumn();
    }

    $offset = ($page - 1) * $annonceParPage;

    $annonces = getAnnonces($conn, $annonceParPage, $offset, $categorieId);

    if ($annonces === false) {
        echo json_encode([
            'success' => false,
            'message' => 'Erreur lors de la récupération des annonces'
        ]);
        return;
    }

    if ($categorieId) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM annonces WHERE quantite_disponible_annonce > 0 AND id_categorie = :categorie");
        $stmt->execute(['categorie' => $categorieId]);
        $totalAnnonces = (int)$stmt->fetchColumn();
        
    } else {
        $stmt = $conn->query("SELECT COUNT(*) FROM annonces WHERE quantite_disponible_annonce > 0");
        $totalAnnonces = (int)$stmt->fetchColumn();
        
    }

    $totalPages = ceil($totalAnnonces / $annonceParPage);

    echo json_encode([
        'success' => true,
        'annonces' => $annonces,
        'page' => $page,
        'totalpages' => $totalPages
    ]);
}

function publierProduitController($conn, $session, $post, $files) {
    if (empty($session['id'])) {
       $_SESSION['error'] =	'Utilisateur non connecté';
    }

    $iduser = $session['id'];
    $id_boutique = getBoutiqueByUser($conn, $iduser);

    if(!$id_boutique){
        $_SESSION['success'] = "Veuillez créer une boutique avant de publier";
        $_SESSION['need_boutique'] = true;
        header("Location: index.php?page=addproduct");
        exit;
	}

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return '';

    $idboutique = intval($id_boutique);
    $title = filter_var($post['nom_produit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $quantite = filter_var($post['quantite'] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $prix = filter_var($post['prix_du_produit'] ?? '', FILTER_SANITIZE_NUMBER_INT);
    $categorie = $post['categorie'] ?? '';
    $description = filter_var($post['description'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $annonce = $files['image_de_annonce'] ?? null;
    $annonce1 = $files['image_de_annonce1'] ?? null;
	
    if (empty($title) || empty($quantite) || empty($prix) || empty($categorie) || empty($annonce['name'] ?? '' ) || empty($annonce1['name'] ?? '')) {
        $_SESSION['success'] = 'Tous les champs doivent être remplis';
    }
    
    $id_categorie = getCategorieBySousCategorie($conn, $categorie);
	
    $produitDir = __DIR__ . '/../../assets/product/';
    
    $filename = basename($annonce["name"]);
    $filenameunique = time() . '_' . $filename;
    $imagePath = $produitDir . $filenameunique;

    $filename1 = basename($annonce1["name"]);
    $filenameunique1 = time() . '_1_' . $filename1;
    $imagePath1 = $produitDir . $filenameunique1;

	if (!is_dir($produitDir)) {
        mkdir($produitDir, 0755, true);
    }
    
    $filetarget = $produitDir . $filenameunique;
    $filetarget1 = $produitDir . $filenameunique1;

    if (!move_uploaded_file($annonce['tmp_name'], $filetarget) || !move_uploaded_file($annonce1['tmp_name'], $filetarget1)) {
        $_SESSION['success'] = 'Erreur lors du téléchargement de l\'image';
        
    }

    $success = createAnnonce($conn, $idboutique, $title, $quantite, $prix, $filenameunique, $filenameunique1, $id_categorie, $description);

    if ($success) {
        $_SESSION['success'] = "Annonce publiée";
        
    } else {
        $_SESSION['success'] = "Erreur lors de l\'insertion de l\'annonce, reéssayé"; 
    }
    
    header("Location: index.php?page=addproduct");
    exit;
}


function deleteAnnonce($conn){

    header('Content-Type: application/json');

    if(!isset($_SESSION['id'])) {
        http_response_code(403);
        header('Location: index.php?page=connexion');
        exit();
    }

    $input = json_decode(file_get_contents('php://input'), true);

    $id_annonce = intval($input['id_annonce']);

    if(deleteAnnonceById($conn, $id_annonce)) {
        jsonResponse(true, 'Annonce supprimée avec succès');
    } else {
        jsonResponse(false, 'Erreur lors de la suppression de l\'annonce' );
    }
}

function modAnnonce(PDO $conn, int $id_annonce): void {
    
    $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_SPECIAL_CHARS);
    $quantite = filter_input(INPUT_POST, 'quantite', FILTER_VALIDATE_INT);
    $prix = filter_input(INPUT_POST, 'prix', FILTER_VALIDATE_INT);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($quantite === false && $prix === false && empty($description &&empty($titre))) {
        $_SESSION['success'] = "Données invalides";
    } else {
        if(updateAnnonce($conn, $id_annonce, $titre, $quantite, $prix, $description)) {
            $_SESSION['success'] = 'Annonce modifiée avec succès';
        } else {
            $_SESSION['success'] = 'Erreur lors de la modification de l\'annonce';
        }
    }

    header('Location: index.php?page=modproduct&id=' . $id_annonce);
    exit();
}


function rechercheProduit(PDO $conn): void
{
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        echo json_encode([
            'success' => false,
            'message' => 'Méthode non autorisée'
        ]);
        return;
    }

    $q = trim($_GET['q'] ?? '');

    if (strlen($q) < 2) {
        echo json_encode([
            'success' => false,
            'message' => 'Mot clé trop court',
            'total' => 0,
            'annonces' => []
        ]);
        return;
    }
    
    if(isset($_SESSION['id'])){
        $iduser = $_SESSION['id'];
    }else{
        $iduser = null;
    }
    
    

    try {

        $resultat = recherche($conn, $q, $iduser);

        echo json_encode([
            'success' => true,
            'total' => $resultat['total'],
            'annonces' => $resultat['annonces']
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'success' => false,
            'message' => 'Erreur serveur'
        ]);

    }
}


function categorieSousCategorie(PDO $conn): array{
        
        $haveboutique = getBoutiqueByUser($conn, $_SESSION['id']);
            if(!$haveboutique){
                return [];
            }
        
        $sousCategorie = getBoutiqueSousCategorie($conn, $haveboutique);
            
        return $sousCategorie;
    }



?>