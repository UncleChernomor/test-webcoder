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

    protected function getFields(): array
    {
        // collected all properties except id, db, nameTable
        $vars = get_object_vars($this);
        unset($vars['id'], $vars['db'], $vars['nameTable']);
        return $vars;
    }

    /**
     * @return void
     *
     * @throws \PDOException
     */
    public function save(): void
    {
        if (empty($this->id)) {
            $this->insert();
        } else {
            $this->update();
        }
    }

    /**
     * @return void
     *
     * @throws \PDOException
     */
    protected function insert(): void
    {
        $fields = $this->getFields();
        $columns = implode(', ', array_keys($fields));
        $placeholders = ':' . implode(', :', array_keys($fields));

        $sql = "INSERT INTO {$this->nameTable} ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);
        foreach ($fields as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        $this->id = (int) $this->db->lastInsertId();
    }

    /**
     * @return void
     *
     * @throws \PDOException
     */
    protected function update(): void
    {
        $fields = $this->getFields();
        $set = implode(', ', array_map(fn($k) => "$k = :$k", array_keys($fields)));

        $sql = "UPDATE {$this->nameTable} SET $set WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        foreach ($fields as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            throw new \PDOException("Record with ID {$this->id} didn't found for update");
        }
    }

    /**
     * delete entity from ID
     *
     * @throws Exception
     */
    public function delete(): void
    {
            $sql = "DELETE FROM {$this->nameTable} WHERE id = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                throw new \PDOException("Record with ID {$this->id} didn't found for delete");
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
