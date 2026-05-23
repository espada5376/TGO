<?php  


require_once __DIR__ . '/../models/annonces.php';
require_once __DIR__ . '/../controllers/annonce.php';

function modproductpagecontroller(PDO $conn){
    
	if(!isset($_SESSION['id'])) {
    header('Location: index.php?page=connexion');
    exit();
    }
	
    $id_user = $_SESSION['id'];
    $id_annonce = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if (!$id_annonce) {
        die('Annonce invalide');
    }

    $annonce = getAnnonceWithOwner($conn, $id_annonce, $id_user);

    if (!$annonce) {
        http_response_code(403);
		header('Location: ' . url('403'));
        exit();
    }

    $annonce = getAnnonceInformationByIdAnnonce($conn, $id_annonce);

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        modAnnonce($conn, $id_annonce);
    }

    require_once __DIR__ . '/../../views/modproduct.php';

}

?>