<?php

    require_once __DIR__ . '/../models/boutiques.php';
    require_once __DIR__ . '/../models/annonces.php';
    require_once __DIR__ . '/../controllers/annonce.php';
	require_once __DIR__ . '/../controllers/boutique.php';

    function addproductpagecontroller(PDO $conn){

        if (!isset($_SESSION['id'])) {
        header('Location: /connexion');
        exit;
        }
        
        $boutiqueenseigne = getBoutique($conn, $_SESSION['id']);
		$sousCategories = categorieSousCategorie($conn);
        
        $StatusPublication = '';
        $files = $_FILES;
        $post = $_POST;
        $session = $_SESSION;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $StatusPublication = publierProduitController($conn, $session, $post, $files);
        }  

        require_once __DIR__ . '/../../views/addproduct.php';

    }
    
?>