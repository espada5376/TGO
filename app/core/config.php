<?php

// =========================
// BASE URL — single source of truth
// =========================
$_host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
$_scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$_local  = in_array(explode(':', $_host)[0], ['localhost', '127.0.0.1']);

define('BASE_URL',   $_local
    ? 'http://localhost/TogoMarket/TGO/'
    : $_scheme . '://' . $_host . '/');

define('ASSETS_URL',  BASE_URL . 'assets/');
define('ASSETS_PATH', dirname(dirname(__DIR__)) . '/assets/');
