<?php

namespace Chernomor\WebCoder;

class App
{
    public static function run(): void
    {
        $router = new Router();
        echo "run";
        $router->dispatch($_SERVER['REQUEST_URI']);
    }
}