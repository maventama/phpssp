<?php
// app/Router.php

class Router {
    private $routes = [];

    public function add($method, $route, $action) {
        // Ubah route menjadi regex dengan mendeteksi parameter dinamis `{param}`
        $route = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_-]+)', $route);
        $route = str_replace('/', '\/', $route);
        $this->routes[] = [
            'method' => strtoupper($method),
            'route' => '/^' . $route . '$/',
            'action' => $action,
        ];
    }

    public function dispatch($method, $uri) {
        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) && preg_match($route['route'], $uri, $matches)) {
                // Hapus indeks numerik dari hasil match
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                // Pecah action menjadi controller dan metode
                list($controller, $method) = explode('@', $route['action']);

                // Panggil controller dengan parameter
                require_once __DIR__ . "/../controllers/{$controller}.php";
                $controllerInstance = new $controller();
                
                return call_user_func_array([$controllerInstance, $method], $params);
            }
        }
        // Jika route tidak ditemukan, tampilkan 404
        http_response_code(404);
        echo "404 Not Found";
    }
}
