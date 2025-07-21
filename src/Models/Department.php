<?php

declare(strict_types=1);

namespace Chernomor\WebCoder\Models;

use PDO;

class Department extends RootModel
{
    public function __construct(
        public PDO $db,
        protected ?int $id,
        protected ?string $name = '',
        protected string $nameTable = 'department'
    ) {
        parent::__construct($db, $id, $name, $nameTable);
    }
}