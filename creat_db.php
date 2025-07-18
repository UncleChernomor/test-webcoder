<?php
try {
    // Создаем соединение с SQLite
    $pdo = new PDO('sqlite:'.DB_PATH);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // table departments exists
    $departmentTableExists = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='department'")->fetch();

    if ( ! $departmentTableExists) {
        // create a table department
        $pdo->exec("
            CREATE TABLE department (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT UNIQUE NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
        echo "Table 'department' create successfully.".PHP_EOL;
    } else {
        echo "Table 'department' is already exists.".PHP_EOL;
    }

    // Table user exists
    $userTableExists = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='user'")->fetch();

    if ( ! $userTableExists) {
        // create a table user
        $pdo->exec("
            CREATE TABLE user (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email TEXT UNIQUE NOT NULL,
                name TEXT NOT NULL,
                address TEXT NOT NULL,
                phone TEXT NOT NULL,
                comments TEXT,
                department_id INTEGER NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (department_id) REFERENCES department(id)
            )
        ");
        echo "Table 'user' created successfully.".PHP_EOL;
    } else {
        echo "Table 'users' is already exists.".PHP_EOL;
    }

    // Add basis departments, if the table department is empty
    $departmentCount = $pdo->query("SELECT COUNT(*) FROM department")->fetchColumn();

    if ($departmentCount == 0) {
        $departments = [
            'IT',
            'Sail',
            'Accountant',
            'HR',
            'Marketing',
        ];

        $stmt = $pdo->prepare("INSERT INTO department (name) VALUES (?)");
        foreach ($departments as $department) {
            $stmt->execute([$department]);
        }
        echo "Basis departments add to table departments".PHP_EOL;
    }

    echo "Database is ready: ".DB_PATH.PHP_EOL;

} catch (PDOException $e) {
    echo "Error while working with database: ".$e->getMessage().PHP_EOL;
}



