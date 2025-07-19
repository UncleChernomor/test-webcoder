<?php
declare(strict_types=1);

namespace Chernomor\WebCoder\Controllers;

abstract class RootController
{
    protected function render($view, $params = []): void
    {
        extract($params);
        $path = __DIR__ . "/../Views/$view.php";
        if (!file_exists($path)) {
            throw new \Exception("View $view not found");
        }

        ob_start();
        include $path;
        $content = ob_get_clean();

        $layout = __DIR__ . "/../Views/layouts/main.php";

        if (file_exists($layout)) {
            include $layout;
        } else {
            throw new \Exception("Layout $layout not found");
        }
    }
}