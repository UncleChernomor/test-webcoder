<?php
/**
 * Point of entrance for embedded PHP server
 * Star: php -S localhost:3000 start.php
 */

// Check server
if (php_sapi_name() !== 'cli-server') {
    die('Этот файл предназначен только для встроенного PHP сервера');
}

// get URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// get static files (CSS, JS, image)
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

// redirect index.php
require_once __DIR__ . '/public/index.php';

