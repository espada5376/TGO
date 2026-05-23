<?php

function addLikecontroller(PDO $conn) {

    if (empty($_SESSION['id'])) {
        echo json_encode(['success' => false, 'message' => 'Connectez-vous pour ajouter au panier']);
        exit;
    }

    $input = json_decode(file_get_contents("php://input"), true);
    $photo_id = isset($input['photo_id']) ? intval($input['photo_id']) : 0;

    if ($photo_id === 0) {
        echo json_encode(['success' => false, 'message' => 'Aucun ID reçu']);
        exit;
    }

	$user_id = $_SESSION['id'];

    if (hasLiked($conn, $user_id, $photo_id)) {
        removeLike($conn, $user_id, $photo_id);
        $message = "Like retiré";

    } else {
        addLike($conn, $user_id, $photo_id);
        $message = "Like ajouté";
    }


$data = getLikes($conn, $_SESSION['id']);

    echo json_encode([
    'success' => true,
    'message' => $message,
    'totallike' => $data['total']
    ]);

}

function applyLike($conn){
    
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') 
        echo json_encode([
        'success' => false,
        'message' => 'erreur',
    ]);
    
    if(!isset($_SESSION['id'])){
        echo json_encode([
            'success' => false,
            'message' => 'Vous n\'etes pas connecter'
        ]);
        exit;
    }

    $data = getLikes($conn, $_SESSION['id']);

    echo json_encode([
        'success' => true,
        'totallike' => $data['total'],
        'id_annonce' => $data['id_annonce']
    ]);
}

?>

