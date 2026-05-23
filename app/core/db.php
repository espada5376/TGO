<?php
$host = 'localhost';
$dbname = 'tg';
$user = 'root';
$password = '';

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
    $conn->exec("
    SET character_set_client = utf8mb4,
        character_set_connection = utf8mb4,
        character_set_results = utf8mb4,
        collation_connection = utf8mb4_general_ci
");
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>