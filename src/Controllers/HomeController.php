<?php

namespace Chernomor\WebCoder\Controllers;

use Chernomor\WebCoder\Controllers\RootController;

class HomeController extends RootController
{
    public function index(): void
    {
        $this->render('pages/home');
    }
}