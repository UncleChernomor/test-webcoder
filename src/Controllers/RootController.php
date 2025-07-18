<?php
declare(strict_types=1);
namespace Chernomor\WebCoder\Controllers;

abstract class RootController
{    protected function render($view, $params = []): void
    {
        extract($params);
        include __DIR__ . "/../Views/$view.php";
    }
}