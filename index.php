<?php

function startSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

startSession();

require_once __DIR__ . '/app/core/db.php';
require_once __DIR__ . '/app/core/jsonResponse.php';
require_once __DIR__ . '/app/controllers/pages.php';
require_once __DIR__ . '/app/controllers/apicontroller.php';

function url(string $path): string {
    $base = 'https://tg.infinityfreeapp.com/';
    return $base . ltrim($path, '/');
}

function slugifyBoutique($text) {
    $text = trim(mb_strtolower($text, 'UTF-8'));
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
    $text = preg_replace('/[^a-z0-9\-]/', '', $text);
    $text = preg_replace('/-+/', '-', $text);
    $text = trim($text, '-');

    return substr($text, 0, 60);
}


// =========================
// ROUTING
// =========================
$page = $_GET['page'] ?? null;

if (!$page) {
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    if ($uri !== '') {
        $segments = explode('/', $uri);
        $page = $segments[0];
    }
}

$page = $page ?: 'home';
$page = str_replace('-', '_', $page);


// =========================
// API
// =========================
if ($page === 'api') {
    $action = $_GET['action'] ?? null;

    if (!$action) {
        http_response_code(400);
        echo json_encode(['error' => 'Action manquante']);
        exit;
    }

    apiController($conn, $action);
    exit;
}


// =========================
// PAGES ERREURS
// =========================
if ($page === '404') {
    http_response_code(404);
    require __DIR__ . '/components/404page.php';
    exit;
}

if ($page === '403' || $page === 'accesrefuse') {
    http_response_code(403);
    require __DIR__ . '/components/403page.php';
    exit;
}


// =========================
// PAGE DYNAMIQUE
// =========================
$function = $page . 'Page';

if (function_exists($function)) {

    $function($conn);

    // Pages sans footer
    $noFooterPages = [
        'apPage',
        'pcPage',
        'cguPage',
        'connexionPage',
        'inscriptionPage'
    ];

    if (!in_array($function, $noFooterPages)) {
        require_once __DIR__ . '/components/footer.php';
    }

} else {

    // =========================
    // 404 GLOBAL
    // =========================
    http_response_code(404);
    require __DIR__ . '/components/404page.php';
    exit;
}

?>