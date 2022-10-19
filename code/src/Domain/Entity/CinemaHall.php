<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Entity;

use Nikolai\Php\Domain\Collection\LazyLoadCollection;

class CinemaHall extends AbstractEntity
{
    private ?int $id = null;

    private string $name;

    private LazyLoadCollection $cinemaHallPlaceRelation;

    public function __construct(?int $id, string $name, ?LazyLoadCollection $cinemaHallPlaceRelation = null)
    {
        $this->id = $id;
        $this->name = $name;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
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