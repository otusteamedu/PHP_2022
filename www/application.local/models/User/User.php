<?php
declare(strict_types=1);
namespace app\models\User;

class User {
    private string $id;
    private string $name;
    private string $surname;

    public function __construct(
        string $id,
        string $name,
        string $surname
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }
}
