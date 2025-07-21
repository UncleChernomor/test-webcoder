<?php

declare(strict_types=1);

namespace Chernomor\WebCoder\Controllers;

use Chernomor\WebCoder\Database;
use Chernomor\WebCoder\Models\Department;
use Chernomor\WebCoder\Models\User;

class UserController extends RootController
{
    public function index(): void
    {
        $this->render('pages/users/index');
    }

    public function create(): void
    {
        $pdo = Database::getInstance()->getConnection();
        $department = new Department($pdo, null, null);
        $department->getAll();

        $this->render('pages/users/create', ['departments' => $department->getAll()]);
    }

    public function store(): void
    {
        $pdo = Database::getInstance()->getConnection();
        $users = new User($pdo);

        if (($error = $users->validate($_POST))) {
            $this->render('pages/users/index', ['error' => $error]);
        }


        $users->save();

        header('Location: /users');
        exit;
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