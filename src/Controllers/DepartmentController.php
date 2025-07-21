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

    public function edit(int $id): void
    {
        $this->render("pages/departments/edit");
    }
}