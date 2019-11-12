<?php
declare(strict_types=1);

namespace App\Domain\User\Model;

class User
{
    private $id;
    private $username;
    private $name;

    public function __construct(int $id, string $username, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->username  = $username;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
