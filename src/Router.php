<?php

namespace Chernomor\WebCoder;

class Router
{
    private $routes = [];

    public function __construct()
    {
        $this->routes = [
            '/users' => ['controller' => 'UserController', 'action' => 'index'],
            '/user/(\d+)' => ['controller' => 'UserController', 'action' => 'show'],
            '/user-add' => ['controller' => 'UserController', 'action' => 'create'],
            '/departments' => ['controller' => 'DepartmentController', 'action' => 'index'],
            '/department-add' => ['controller' => 'DepartmentController', 'action' => 'create'],
            // и т.д.
        ];
    }

    public function dispatch($uri)
    {
        $path = parse_url($uri, PHP_URL_PATH);
        foreach ($this->routes as $pattern => $route) {
            $pattern = '#^' . $pattern . '$#';
            if (preg_match($pattern, $path, $matches)) {
                $controllerName = "\\Chernomor\\WebCoder\\Controllers\\" . $route['controller'];
                $controller = new $controllerName();
                $action = $route['action'];
                $params = array_slice($matches, 1);
                call_user_func_array([$controller, $action], $params);
                return;
            }
        }
        // 404
        http_response_code(404);
        echo 'Page not found';
    }
}