<?php

declare(strict_types=1);

namespace Chernomor\WebCoder\Controllers;

class UserController extends RootController
{
    public function index(): void
    {
        $this->render('pages/users/index');
    }

    public function create(): void
    {
        $this->render('pages/users/create');
    }

    public function edit(int $id): void
    {
        $this->render('pages/users/edit', ['id' => $id]);
    }

    public function show(int $id): void
    {
        $this->render('pages/users/show', ['id' => $id]);
    }
}