<?php

require_once __DIR__ . "/../middleware/RateLimiter.php";
require_once __DIR__ . "/../middleware/InputSanitizer.php";

class Router {
    private $routes = [];
    private $middleware = [];

    // Menambahkan route dan middleware
    public function add($method, $route, $action, $middleware = []) {
        // Escape karakter khusus dalam route statis
        $routePattern = preg_quote($route, '/'); // Menghindari karakter khusus dalam regex

        // Menangani parameter dinamis
        $routePattern = preg_replace_callback('/\{([a-zA-Z0-9_]+)\}/', function ($matches) {
            return '(?P<' . $matches[1] . '>[a-zA-Z0-9_-]+)';
        }, $routePattern);

        // Membuat pola regex dengan pemisah '/' yang sesuai
        $routePattern = '/^' . $routePattern . '$/';

        // Menambahkan route yang telah diproses
        $this->routes[] = [
            'method' => strtoupper($method),
            'route' => $routePattern,
            'action' => $action,
            'middleware' => $middleware,
        ];
    }

    // Menjalankan middleware dan controller
    public function dispatch($method, $uri) {
        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method)) {
                // Deklarasi variabel $matches untuk menampung hasil preg_match
                $matches = [];

                // Cek apakah rute cocok dengan URL
                if (preg_match($route['route'], $uri, $matches)) {
                    // Cek dan jalankan middleware
                    foreach ($route['middleware'] as $middlewareClass) {
                        $middleware = new $middlewareClass();
                        $middleware->handle($method, $uri);
                    }

                    // Ambil parameter dinamis dari URL
                    $params = [];
                    foreach ($matches as $key => $value) {
                        if (is_string($key)) {
                            $params[$key] = $value;
                        }
                    }

                    // Ambil controller dan action
                    list($controller, $action) = explode('@', $route['action']);
                    require_once __DIR__ . "/../controllers/{$controller}.php";
                    $controllerInstance = new $controller();
                    return call_user_func_array([$controllerInstance, $action], $params);
                }
            }
        }

        // Jika route tidak ditemukan
        http_response_code(404);
        echo "404 - Page Not Found";
    }
}
