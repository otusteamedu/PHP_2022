<?php

declare(strict_types=1);

namespace App\DesignPatterns\DataMapper;

class Hall
{
    private int $id;
    private string $title;
    private int $capacity;
    private \DateTimeImmutable $createdAt;

    public function __construct(int $id, string $title, int $capacity, \DateTimeImmutable $createdAt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->capacity = $capacity;
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): void
    {
        $this->capacity = $capacity;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}