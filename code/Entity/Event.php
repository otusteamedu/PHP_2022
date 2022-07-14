<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use DateTimeInterface;

class Event
{
    private DateTimeInterface $time_start;
    private DateTimeInterface $time_end;

    public function __construct(
        private ?int $id,
        private string $name,
        string $time_start,
        string $time_end
    ) {
        $this->setTimeStart($time_start);
        $this->setTimeEnd($time_end);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getTimeStart(): DateTimeInterface
    {
        return $this->time_start;
    }

    public function setTimeStart(string $time_start): void
    {
        $this->time_start = new DateTime($time_start);
    }

    public function getTimeEnd(): DateTimeInterface
    {
        return $this->time_end;
    }

    public function setTimeEnd(string $time_end): void
    {
        $this->time_end = new DateTime($time_end);
    }
}