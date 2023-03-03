<?php

declare(strict_types=1);

namespace unsorted\DesignPatterns\TableDataGateway;

class HallDTO
{
    public ?int $id;
    public string $title;
    public int $capacity;
    public \DateTimeImmutable $createdAt;
}