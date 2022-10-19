<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Entity;

use Nikolai\Php\Domain\Collection\AbstractLazyCollection;
use Nikolai\Php\Domain\Collection\LazyLoadCollection;

class Place extends AbstractEntity
{
    private ?int $id = null;

    private int $row;

    private int $col;

    private LazyLoadCollection $cinemaHallPlaceRelation;

    public function __construct(?int $id, int $row, int $col, ?LazyLoadCollection $cinemaHallPlaceRelation = null)
    {
        $this->id = $id;
        $this->row = $row;
        $this->col = $col;
        if ($cinemaHallPlaceRelation) {
            $this->cinemaHallPlaceRelation = $cinemaHallPlaceRelation;
        } else {
            $this->cinemaHallPlaceRelation = new LazyLoadCollection($this, 'cinemaHallPlaceRelation');
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getRow(): int
    {
        return $this->row;
    }

    public function setRow(int $row): self
    {
        $this->row = $row;
        return $this;
    }

    public function getCol(): int
    {
        return $this->col;
    }

    public function setCol(int $col): self
    {
        $this->col = $col;
        return $this;
    }

    public function getCinemaHallPlaceRelation(): ?LazyLoadCollection
    {
        return $this->cinemaHallPlaceRelation;
    }

    public function setCinemaHallPlaceRelation(?LazyLoadCollection $cinemaHallPlaceRelation): self
    {
        $this->cinemaHallPlaceRelation = $cinemaHallPlaceRelation;
        return $this;
    }
}