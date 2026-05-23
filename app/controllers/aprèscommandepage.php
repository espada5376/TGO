<?php


function apresCmdpage($conn)
{

	$id_annonce = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    if(!$id_annonce){
        http_response_code(404);
    	exit;
    }

	require_once __DIR__ . '/../../views/aprèscommande.php';
    
}

?>