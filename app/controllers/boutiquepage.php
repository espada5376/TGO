<?php
    
require __DIR__ . '/../models/boutiques.php';
require __DIR__ . '/../controllers/boutique.php';

if (!isset($_SESSION['id'])) {
    header('Location: index.php?page=connexion');
    exit;
}

$boutique = getBoutique($conn, $_SESSION['id']);

require_once __DIR__ . '/../../views/boutique.php';

?>