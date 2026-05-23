<?php

require_once __DIR__ . '/../models/utilisateurs.php';
require_once __DIR__ . '/../controllers/utilisateur.php';


function signInPagecontroller(PDO $conn){
    
    $erreurconnexion = '';

    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $tel = filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_NUMBER_INT);
        $password = trim($_POST['mdp']);
        login($tel, $password, $conn);
    }

    require_once __DIR__ . '/../../views/auth/signIn.php';
}

function signUppagecontroller(PDO $conn){
    
    startSession();
	
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        handleRegister($conn);
    }
    	
    

    require_once __DIR__ . '/../../views/auth/signUp.php';
}

?>