<?php
declare(strict_types=1);

namespace Chernomor\WebCoder\Models;

use PDO;

abstract class RootModel
{
    public function __construct(protected PDO $db)
    {
    }
}