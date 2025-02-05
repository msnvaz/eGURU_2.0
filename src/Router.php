<?php

namespace App;

class Router
{
    protected $routes = [];

    private function addRoute($route, $controller, $action, $method)
    {
        $this->routes[$method][] = [
            'route' => $route,
            'controller' => $controller, 
            'action' => $action
        ];
    }

    public function get($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "GET");
    }

    public function post($route, $controller, $action)
    {
        $this->addRoute($route, $controller, $action, "POST");
    }

    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes[$method] as $route) {
            // Convert dynamic routes to regex
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route['route']);
            $pattern = '#^' . str_replace('/', '\\/', $pattern) . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                // Remove the full match
                array_shift($matches);

                // Instantiate the controller
                $controller = new $route['controller']();
                
                // Call the method with matched parameters
                call_user_func_array(
                    [$controller, $route['action']], 
                    $matches
                );
                return;
            }
        }

        throw new \Exception("No route found for URI: $uri");
    }

    public static function redirect($url) {
        header("Location: $url");
        exit();
    }
}