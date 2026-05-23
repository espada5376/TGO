<?php

require_once __DIR__ . '/../models/commandes.php';
require_once __DIR__ . '/../controllers/commande.php';
require_once __DIR__ . '/../core/jsonResponse.php';   

$tarifsRetrait = [
    [
        'min' => 100,
        'max' => 500,
        'frais' => 50
    ],
    [
        'min' => 501,
        'max' => 5000,
        'frais' => 100
    ],
    [
        'min' => 5001,
        'max' => 20000,
        'frais' => 300
    ],
    [
        'min' => 20001,
        'max' => 50000,
        'frais' => 600
    ],
    [
        'min' => 50001,
        'max' => 100000,
        'frais' => 1000
    ],
    [
        'min' => 100001,
        'max' => 200000,
        'frais' => 3100
    ],
    [
        'min' => 200001,
        'max' => 300000,
        'frais' => 3700
    ]
];

getFraisRetrait($tarifsRetrait);

?>