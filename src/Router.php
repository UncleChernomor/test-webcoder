<?php

namespace Chernomor\WebCoder;

class Router
{
    private $routes = [
        'GET' => [
            '/' => ['controller' => 'HomeController', 'action' => 'index'],
            '/users' => ['controller' => 'UserController', 'action' => 'index'],
            '/users/create' => ['controller' => 'UserController', 'action' => 'create'],
            '/users/(\d+)' => ['controller' => 'UserController', 'action' => 'show'],
            '/users/(\d+)/edit' => ['controller' => 'UserController', 'action' => 'edit'],
            '/departments' => ['controller' => 'DepartmentController', 'action' => 'index'],
            '/departments/create' => ['controller' => 'DepartmentController', 'action' => 'create'],
            '/departments/(\d+)' => ['controller' => 'DepartmentController', 'action' => 'show'],
            '/departments/(\d+)/edit' => ['controller' => 'DepartmentController', 'action' => 'edit'],
        ],
        'POST' => [
            '/users' => ['controller' => 'UserController', 'action' => 'store'],
            '/users/(\d+)' => ['controller' => 'UserController', 'action' => 'update'],
            '/users/(\d+)/delete' => ['controller' => 'UserController', 'action' => 'delete'],
            '/departments' => ['controller' => 'DepartmentController', 'action' => 'store'],
            '/departments/(\d+)' => ['controller' => 'DepartmentController', 'action' => 'update'],
            '/departments/(\d+)/delete' => ['controller' => 'DepartmentController', 'action' => 'delete'],
        ]
    ];

    public function __construct()
    {}

    public function dispatch($uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];


        if (!isset($this->routes[$method])) {
            $this->methodNotAllowed();
            return;
        }

        foreach ($this->routes[$method] as $pattern => $route) {
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $path, $matches)) {
                $controllerName = "\\Chernomor\\WebCoder\\Controllers\\" . $route['controller'];

                if (!class_exists($controllerName)) {
                    $this->notFound();
                    return;
                }

                $controller = new $controllerName();
                $action = $route['action'];

                if (!method_exists($controller, $action)) {
                    $this->notFound();
                    return;
                }

                $params = array_slice($matches, 1);
                call_user_func_array([$controller, $action], $params);
                return;
            }
        }


        $this->notFound();
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo 'Page not found';
    }


    private function methodNotAllowed(): void
    {
        http_response_code(405);
        echo 'Method not allowed';
    }
}