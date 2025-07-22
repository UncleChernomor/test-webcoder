<?php

declare(strict_types=1);

namespace Chernomor\WebCoder\Models;
use PDO;

class User extends RootModel
{
    public function __construct(
        public PDO $db,
        protected ?int $id = null,
        protected ?string $name = null,
        protected string $nameTable = 'user',
        protected ?string $email = null,
        protected ?string $address = null,
        protected ?string $phone = null,
        protected ?string $comments = null,
        protected ?int $department_id = null
    ) {
        parent::__construct($db, $id, $name, $nameTable);;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getComments(): string
    {
        return $this->comments;
    }

    public function setComments(string $comments): void
    {
        $this->comments = $comments;
    }

    public function getDepartmentId(): int
    {
        return $this->department_id;
    }

    public function setDepartmentId(int $departmentId): void
    {
        $this->department_id = $departmentId;
    }

    public function validate(array $data): array
    {
        $errors = parent::validate($data);

        if (isset($data['email']) && !empty($data['email'])) {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Invalid email format.';
            }
        }

        if (isset($data['address-1']) && empty($data['address-1'])) {
            $errors['address'] = 'Address is required.';
        }

        if (isset($data['phone']) && !empty($data['phone'])) {
            if (!preg_match('/^\+?\d{7,15}$/', $data['phone'])) {
                $errors['phone'] = 'Invalid phone number format.';
            }
        }

        if (isset($data['department']) && !empty($data['department'])) {
            if (!is_int((int)$data['department'])) {
                $errors['department'] = 'Invalid department ID.';
            }
        }

        return  $errors;
    }
}