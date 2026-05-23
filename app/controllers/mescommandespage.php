<?php

function mescommandespagecontroller(){

    if (!isset($_SESSION['id'])) {
        header('Location: index.php?page=connexion');
        exit;
    } 

    require_once __DIR__ . '/../../views/mescommandes.php';

}

?>