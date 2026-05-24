<?php

$host    = env('DB_HOST',    'localhost');
$dbname  = env('DB_NAME',    'TG');
$user    = env('DB_USER',    'root');
$password= env('DB_PASS',    '');
$charset = env('DB_CHARSET', 'utf8mb4');

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=$charset",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
    $conn->exec("
        SET character_set_client     = $charset,
            character_set_connection = $charset,
            character_set_results    = $charset,
            collation_connection     = {$charset}_general_ci
    ");
} catch (PDOException $e) {
    if (APP_DEBUG) {
        die("Erreur de connexion : " . $e->getMessage());
    } else {
        die("Une erreur est survenue. Veuillez réessayer plus tard.");
    }
}
