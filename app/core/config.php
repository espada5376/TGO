<?php

// =======================================================
// Chargeur .env — lit le fichier racine/.env
// =======================================================
function loadEnv(string $path): void {

    if (!is_file($path)) {
        return; // .env absent → les valeurs par défaut ci-dessous s'appliquent
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $line = trim($line);

        // Ignorer les commentaires et lignes vides
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        // Séparer KEY=VALUE (VALUE peut contenir des =)
        $pos = strpos($line, '=');
        if ($pos === false) continue;

        $key   = trim(substr($line, 0, $pos));
        $value = trim(substr($line, $pos + 1));

        // Enlever les guillemets optionnels autour de la valeur
        if (
            strlen($value) >= 2 &&
            (($value[0] === '"' && $value[-1] === '"') ||
             ($value[0] === "'" && $value[-1] === "'"))
        ) {
            $value = substr($value, 1, -1);
        }

        // Exposer via $_ENV, $_SERVER et putenv()
        if (!isset($_ENV[$key])) {
            $_ENV[$key]    = $value;
            $_SERVER[$key] = $value;
            putenv("$key=$value");
        }
    }
}

// Charger le fichier d'environnement (racine du projet)
loadEnv(dirname(__DIR__, 2) . '/.env');

// =======================================================
// Helpers pour lire une variable d'environnement
// =======================================================
function env(string $key, mixed $default = null): mixed {
    $val = $_ENV[$key] ?? getenv($key);
    if ($val === false || $val === '') return $default;

    // Convertir les booléens texte
    return match(strtolower((string)$val)) {
        'true', '1', 'yes' => true,
        'false', '0', 'no' => false,
        default            => $val,
    };
}

// =======================================================
// Constantes de l'application
// =======================================================

// BASE_URL — priorité au .env, sinon auto-détection
$_envBaseUrl = env('BASE_URL');

if ($_envBaseUrl) {
    define('BASE_URL', rtrim($_envBaseUrl, '/') . '/');
} else {
    // Auto-détection local / production
    $_host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $_scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $_local  = in_array(explode(':', $_host)[0], ['localhost', '127.0.0.1']);

    define('BASE_URL', $_local
        ? 'http://localhost/TogoMarket/TGO/'
        : $_scheme . '://' . $_host . '/');
}

define('ASSETS_URL',  BASE_URL . 'assets/');
define('ASSETS_PATH', dirname(__DIR__, 2) . '/assets/');

define('APP_ENV',   env('APP_ENV',   'production'));
define('APP_DEBUG', env('APP_DEBUG', false));
define('APP_NAME',  env('APP_NAME',  'TogoMarket'));
