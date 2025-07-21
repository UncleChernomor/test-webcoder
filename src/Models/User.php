<?php

declare(strict_types=1);

namespace Chernomor\WebCoder\Models;
use PDO;

class User extends RootModel
{
    public function __construct(
        public PDO $db,
        protected ?int $id,
        protected ?string $name,
        protected string $email,
        protected string $address,
        protected string $phone,
        protected string $comments,
        protected int $departmentId
    ) {
        parent::__construct($db, $id, $name);
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
        return $this->departmentId;
    }

    public function setDepartmentId(int $departmentId): void
    {
        $this->departmentId = $departmentId;
    }



}