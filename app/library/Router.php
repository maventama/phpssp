<?php

require_once __DIR__ . "/../middleware/RateLimiter.php";
require_once __DIR__ . "/../middleware/InputSanitizer.php";

class Router
{
    private $routes = [];
    private $middleware = [];


    public function add($method, $route, $action, $middleware = [])
    {
        $routePattern = str_replace('/', '\/', $route);
        $routePattern = preg_replace_callback('/\{([a-zA-Z0-9_]+)\}/', function ($matches) {
            return '(?P<' . $matches[1] . '>[a-zA-Z0-9_-]+)';
        }, $routePattern);
        $routePattern = '/^' . $routePattern . '$/';

        $this->routes[] = [
            'method' => strtoupper($method),
            'route' => $routePattern,
            'action' => $action,
            'middleware' => $middleware,
        ];
    }



    public function dispatch($method, $uri)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method)) {
                $matches = [];
                if (preg_match($route['route'], $uri, $matches)) {
                    foreach ($route['middleware'] as $middlewareClass) {
                        $middleware = new $middlewareClass();
                        $middleware->handle($method, $uri);
                    }

                    $params = [];
                    foreach ($matches as $key => $value) {
                        if (is_string($key)) {
                            $params[$key] = $value;
                        }
                    }

                    list($controller, $action) = explode('@', $route['action']);
                    require_once __DIR__ . "/../controllers/{$controller}.php";
                    $controllerInstance = new $controller();
                    return call_user_func_array([$controllerInstance, $action], $params);
                }
            }
        }

        http_response_code(404);
        echo "404 - Page Not Found";
    }
}
