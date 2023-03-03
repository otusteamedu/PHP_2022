<?php

declare(strict_types=1);

namespace unsorted\DesignPatterns\DataMapper;

class Seat
{
    private int $id;
    private int $row;
    private int $number;
    private int $hallId;

    public function __construct(int $id, int $row, int $number, int $hallId)
    {
        $this->id = $id;
        $this->row = $row;
        $this->number = $number;
        $this->hallId = $hallId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRow(): int
    {
        return $this->row;
    }

    public function setRow(int $row): void
    {
        $this->row = $row;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    public function getHallId(): int
    {
        return $this->hallId;
    }

    public function setHallId(int $hallId): void
    {
        $this->hallId = $hallId;
    }
}