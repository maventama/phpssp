<?php
// app/helper.php

require_once __DIR__ . '/Library/CSRF.php';
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
function csrf_token() {
    return CSRF::generateToken();
}
function dumpdie($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}
function route($name, $params = [])
{
    $router = Router::getInstance();

    $namedRoutes = $router->getNamedRoutes();

    if (!isset($namedRoutes[$name])) {
        throw new Exception("Route {$name} not found.");
    }

    $route = $namedRoutes[$name];

    foreach ($params as $key => $value) {
        $route = str_replace("{{$key}}", $value, $route);
    }


    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
    $baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    $baseUrl = str_replace('index.php', '', $baseUrl);

    $fullUrl = $baseUrl . $route;
    $fullUrl = str_replace('//', '/', $fullUrl);

    return $fullUrl;
}
