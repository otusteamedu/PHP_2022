<?php

declare(strict_types=1);

namespace App\DesignPatterns\TableDataGateway;

class Hall
{
    public ?int $id;
    public string $title;
    public int $capacity;
    public \DateTimeImmutable $createdAt;
}