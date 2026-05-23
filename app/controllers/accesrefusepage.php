<?php
    
require_once __DIR__ . '/../models/annonces.php';

function error403Controller(PDO $conn) {

    http_response_code(403);
    
        function formatMoney($amount) {
    return number_format($amount, 0, '', '.');
	}
    
    // Suggestions (ex: annonces récentes)
    $annonces = getTop20Annonces($conn);

    require_once __DIR__ . '/../../views/403page.php';
}

?>