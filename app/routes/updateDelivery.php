<?php

require_once __DIR__ . '/../models/commandes.php';
require_once __DIR__ . '/../controllers/commande.php';
require_once __DIR__ . '/../core/jsonResponse.php';

updateDeliveryStatut($conn);

?>