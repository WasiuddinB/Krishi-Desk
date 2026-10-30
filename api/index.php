<?php

// Single entry point for Vercel: runs the PHP page that matches the URL.
// Keeps the whole site in one serverless function.

$root = dirname(__DIR__);
$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$path = trim($path, '/');

if($path === '') $path = 'index.php';

$file = realpath($root . '/' . $path);

// Only run .php files inside the project; layouts/ and the helper scripts
// in server/ are includes, not pages.
$allowed_server = ['server/place_order.php', 'server/confirm_payment.php'];
$relative = $file ? str_replace('\\', '/', substr($file, strlen($root) + 1)) : '';

$blocked = !$file
    || strpos($file, $root . DIRECTORY_SEPARATOR) !== 0
    || substr($relative, -4) !== '.php'
    || strpos($relative, 'api/') === 0
    || strpos($relative, 'layouts/') === 0
    || (strpos($relative, 'server/') === 0 && !in_array($relative, $allowed_server));

if($blocked){
    http_response_code(404);
    echo '404 Not Found';
    exit;
}

chdir(dirname($file));
$_SERVER['SCRIPT_NAME'] = '/' . $relative;
$_SERVER['PHP_SELF'] = '/' . $relative;
require $file;
