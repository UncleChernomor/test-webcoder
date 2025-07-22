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
        $pdo = Database::getInstance()->getConnection();
        $department = new Department($pdo, null, null);
        $department->getAll();
        $users = new User($pdo);

        $this->render('pages/users/index',
            [
                'departments' => $department->getAll(),
                'users' => $users->getAll()
            ]);
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
        $filteredData = [
            'name' => trim(filter_var($_POST['name'] ?? '', FILTER_SANITIZE_STRING)),
            'email' => trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL)),
            'address-1' => trim(filter_var($_POST['address-1'] ?? '', FILTER_SANITIZE_STRING)),
            'address-2' => trim(filter_var($_POST['address-2'] ?? '', FILTER_SANITIZE_STRING)),
            'phone' => trim(filter_var($_POST['phone'] ?? '', FILTER_SANITIZE_STRING)),
            'comments' => trim(filter_var($_POST['comment'] ?? '', FILTER_SANITIZE_STRING)),
            'department_id' => filter_var($_POST['department'] ?? 0, FILTER_VALIDATE_INT)
        ];

        try{
            $pdo = Database::getInstance()->getConnection();
            $user = new User($pdo);

            if (($error = $user->validate($filteredData))) {
                $this->render('pages/users/index', ['error' => 'Can\'t add ']);
                return;
            }

            $address = $filteredData['address-1'] . ' ' . $filteredData['address-2'];

            $user->setName($filteredData['name']);
            $user->setEmail($filteredData['email']);
            $user->setAddress($address);
            $user->setPhone($filteredData['phone']);
            $user->setComments($filteredData['comments']);
            $user->setDepartmentId((int)$filteredData['department_id']);

            $user->save();

            header('Location: /users');
            exit;
        } catch (\Exception $e) {
            error_log('Error from created user: ' . $e->getMessage());

            $this->render('pages/users/create', [
                'departments' => (new Department($pdo, null, null))->getAll(),
                'errors' => ['general' => 'Failed to save user: ' . $e->getMessage()],
            ]);

        }

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