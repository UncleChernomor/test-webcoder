<?php

declare(strict_types=1);

namespace Chernomor\WebCoder\Controllers;

use Chernomor\WebCoder\Database;
use Chernomor\WebCoder\Models\Department;

class DepartmentController extends RootController
{
    public function index(): void
    {
        $pdo = Database::getInstance()->getConnection();
        $departments = new Department($pdo, null, null);

        $this->render('pages/departments/index', ['departments' => $departments->getAll()]);
    }

    /**
     * @param int $id
     * @return void
     * @throws \Exception
     */
    public function show(int $id): void
    {
        $pdo = Database::getInstance()->getConnection();
        $department = new Department($pdo, $id, null);

        $this->render("pages/departments/show", ['department' => $department]);
    }

    public function create(): void
    {
        $this->render('pages/departments/create');
    }

    public function store(): void
    {
        $name = trim(filter_var($_POST['name-department'] ?? '', FILTER_SANITIZE_STRING)) ?? null;

        // min validation
        if (!$name || mb_strlen($name) < 2 || mb_strlen($name) > 50) {
            $this->render('pages/departments/create', [
                "error" => "department's name must be between 2 and 50 characters."
            ]);
            return;
        }

        try {
            $pdo = Database::getInstance()->getConnection();
            $department = new Department($pdo, null, $name);
            $department->save();

            header('Location: /departments');
            exit;
        } catch (\Exception $e) {
            error_log('Error from created department: ' . $e->getMessage());

            $this->render('pages/departments/index', [
                "error" => "We couldn't created Department. " . $e->getMessage()
            ]);
        }
    }

    public function delete(int $id): void
    {
        try {
            $pdo = Database::getInstance()->getConnection();
            $department = new Department($pdo, $id, null);
            $department->delete();

            header('Location: /departments');
            exit;

        } catch (\Exception $e) {
            error_log('Error from deleted department: ' . $e->getMessage());

            $this->render('pages/departments/index', [
                "error" => "We couldn't delete Department. Try later."
            ]);
        }
    }

    public function edit(int $id): void
    {
        $this->render("pages/departments/edit");
    }
}