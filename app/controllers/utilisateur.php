<?php

function handleRegister($conn): void {

    session_start();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /inscription');
        exit;
    }

    $nom  = trim(filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_SPECIAL_CHARS));
    $tel  = trim(filter_input(INPUT_POST, 'tel', FILTER_SANITIZE_NUMBER_INT));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $mdp = trim($_POST['mdp'] ?? '');
    $confirmMdp = trim($_POST['confirmemdp'] ?? '');

    if (empty($nom) || empty($tel) || empty($mdp)) {
        $_SESSION['error'] = 'Veuillez remplir tous les champs';
        header('Location: /inscription');
        exit;
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Email invalide';
        header('Location: /inscription');
        exit;
    }

    if (strlen($mdp) < 6) {
        $_SESSION['error'] = 'Le mot de passe doit contenir au moins 6 caractères';
        header('Location: /inscription');
        exit;
    }

    if ($mdp !== $confirmMdp) {
        $_SESSION['error'] = 'Les mots de passe ne correspondent pas';
        header('Location: /inscription');
        exit;
    }

    if (emailOuTelExists($conn, $email, $tel)) {
        $_SESSION['error'] = 'Email ou numéro déjà utilisé';
        header('Location: /inscription');
        exit;
    }

    $newUser = createUser($conn, $nom, $email, $tel, $mdp);

    if (!$newUser) {
        $_SESSION['error'] = 'Erreur lors de l’enregistrement, veuillez réessayer';
        header('Location: /inscription');
        exit;
    }

    $_SESSION['id'] = $newUser['id_utilisateur'];
    $_SESSION['nom'] = $newUser['nom_utilisateur'];
    $_SESSION['email'] = $newUser['email_utilisateur'];
    $_SESSION['tel'] = $newUser['tel_utilisateur'];

    header('Location: /');
    exit;
}



function login($tel, $password, $conn) {
    startSession();

    if (empty($tel) || empty($password)) {
        $_SESSION['error'] = 'Entrez votre téléphone et mot de passe';
        header('Location: /connexion');
        exit;
    }

    $user = findUserByTel($tel, $conn);

    if ($user && password_verify($password, $user['mdp_utilisateur'])) {

        $_SESSION['id'] = $user['id_utilisateur'];
        $_SESSION['nom'] = $user['nom_utilisateur'];
        $_SESSION['email'] = $user['email_utilisateur'];
        $_SESSION['tel'] = $user['tel_utilisateur'];

        header('Location: /profil');
        exit;
    }

    $_SESSION['error'] = 'Identifiants incorrects';
    header('Location: /connexion');
    exit;
}

?>