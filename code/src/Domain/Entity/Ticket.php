<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Entity;

class Ticket extends AbstractEntity
{
    private ?int $id = null;

    private Schedule $schedule;

    private CinemaHallPlaceRelation $cinemaHallPlaceRelation;

    private float $price;

    private bool $status;

    public function __construct(?int $id, Schedule $schedule, CinemaHallPlaceRelation $cinemaHallPlaceRelation, float $price, bool $status)
    {
        $this->id = $id;
        $this->schedule = $schedule;
        $this->cinemaHallPlaceRelation = $cinemaHallPlaceRelation;
        $this->price = $price;
        $this->status = $status;
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

    public function getSchedule(): Schedule
    {
        return $this->schedule;
    }

    public function setSchedule(Schedule $schedule): self
    {
        $this->schedule = $schedule;
        return $this;
    }

    public function getCinemaHallPlaceRelation(): CinemaHallPlaceRelation
    {
        return $this->cinemaHallPlaceRelation;
    }

    public function setCinemaHallPlaceRelation(CinemaHallPlaceRelation $cinemaHallPlaceRelation): self
    {
        $this->cinemaHallPlaceRelation = $cinemaHallPlaceRelation;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;
        return $this;
    }
}