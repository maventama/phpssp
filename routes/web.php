<?php
// routes/web.php

$routes = [
    '/' => ['controller' => 'HomeController', 'action' => 'index'],
    '/about' => ['controller' => 'HomeController', 'action' => 'about'],
];

// Fungsi sederhana untuk menangani rute
function route($uri, $routes) {
    if (array_key_exists($uri, $routes)) {
        $controllerName = $routes[$uri]['controller'];
        $action = $routes[$uri]['action'];

        require_once __DIR__ . '/../app/controllers/' . $controllerName . '.php';
        $controller = new $controllerName;
        $controller->$action();
    } else {
        // Jika rute tidak ditemukan
        http_response_code(404);
        echo "404 - Page Not Found";
    }
}
