<?php

declare(strict_types=1);

namespace Svatel\Code\Model;

final class User
{
    private ?int $id = null;
    private ?string $name = null;
    private ?string $email = null;
    private ?string $number = null;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?string $email = null,
        ?string $number = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->number = $number;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function toArray(): array
    {
        return [
            $this->id,
            $this->name,
            $this->email,
            $this->number
        ];
    }
}
