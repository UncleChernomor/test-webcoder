<?php
declare(strict_types=1);

namespace Chernomor\WebCoder\Models;

use DateTime;
use PDO;
use PDOException;
use Exception;

abstract class RootModel
{
    public function __construct(
        public PDO $db,
        protected ?int $id = null,
        protected ?string $name = null,
        protected string $nameTable = ''
    ) {
        if ($this->id) {
            $this->fillDataByRecord($this->getById($this->id));
        }
    }

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * Add a new entity
     * @param array $params
     * @return int $id
     *
     * @throws Exception
     */
    public function add(array $params): int
    {
        if (empty($params)) {
            throw new Exception("parametrs can't be empty");
        }

        try {
            $columns = implode(', ', array_keys($params));
            $placeholders = ':' . implode(', :', array_keys($params));

            $sql = "INSERT INTO {$this->nameTable} ({$columns}) VALUES ({$placeholders})";

            $stmt = $this->db->prepare($sql);

            foreach ($params as $key => $value) {
                $stmt->bindValue(":{$key}", $value);
            }

            if (!$stmt->execute()) {
                throw new Exception("Don't manage to execute query");
            }

            $newId = (int) $this->db->lastInsertId();

            if ($newId === 0) {
                throw new Exception(" Failed to get ID created record");
            }

            $this->id = $newId;

            return $newId;

        } catch (PDOException $e) {
            throw new Exception("Error Database. Don't create record: " . $e->getMessage());
        }
    }

    /**
     * delete entity from ID
     *
     * @throws Exception
     */
    public function delete(int $id): void
    {
        if ($id <= 0) {
            throw new Exception("ID must be positive integer");
        }

        try {
            $sql = "DELETE FROM {$this->nameTable} WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                throw new Exception("Don't manage to execute query");
            }

            if ($stmt->rowCount() === 0) {
                throw new Exception("Record with ID {$id} didn't found for delete");
            }

        } catch (PDOException $e) {
            throw new Exception("Error Database can't delete record: " . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function edit(int $id, array $params): void
    {
        if ($id <= 0) {
            throw new Exception("ID must be positive integer");
        }

        if (empty($params)) {
            throw new Exception("Parameters can't be empty");
        }

        try {
            $setParts = [];
            foreach (array_keys($params) as $key) {
                $setParts[] = "{$key} = :{$key}";
            }
            $setClause = implode(', ', $setParts);

            $sql = "UPDATE {$this->nameTable} SET {$setClause} WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            foreach ($params as $key => $value) {
                $stmt->bindValue(":{$key}", $value);
            }

            if (!$stmt->execute()) {
                throw new Exception("Can't execute query");
            }

            if ($stmt->rowCount() === 0) {
                throw new Exception("Record with ID {$id} can't be found for update");
            }

        } catch (PDOException $e) {
            throw new Exception("Error Database from update record: " . $e->getMessage());
        }
    }

    /**
     * Get the total count of records in the table
     *
     * @throws Exception On query execution error
     */
    public function getCount(): int
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM {$this->nameTable}";
            $stmt = $this->db->prepare($sql);

            if (!$stmt->execute()) {
                throw new Exception("Failed to execute query for getting records count");
            }

            return (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        } catch (PDOException $e) {
            throw new Exception("Database error while getting records count: " . $e->getMessage());
        }
    }

    /**
     * Get record by ID
     *
     * @throws Exception On query execution error or if record not found
     */
    public function getById(int $id): array
    {
        if ($id <= 0) {
            throw new Exception("ID must be a positive number");
        }

        try {
            $sql = "SELECT * FROM {$this->nameTable} WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                throw new Exception("Failed to execute query for getting record by ID");
            }

            $record = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$record) {
                throw new Exception("Record with ID {$id} not found");
            }

            return $record;

        } catch (PDOException $e) {
            throw new Exception("Database error while getting record by ID: " . $e->getMessage());
        }
    }

    private function fillDataByRecord(array $data): void
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
    }

    /**
     * Get all records from the table
     *
     * @param string $orderBy Field to sort by (default 'id')
     * @param string $orderDirection Sort direction ('ASC' or 'DESC')
     * @throws Exception On query execution error
     */
    public function getAll(): array
    {
        try {

            $sql = "SELECT * FROM {$this->nameTable}";
            $stmt = $this->db->prepare($sql);

            if (!$stmt->execute()) {
                throw new Exception("Failed to execute query for getting all records");
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new Exception("Database error while getting all records: " . $e->getMessage());
        }
    }

}
