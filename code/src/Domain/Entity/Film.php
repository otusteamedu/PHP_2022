<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Entity;

use Nikolai\Php\Domain\Collection\LazyLoadCollection;

class Film extends AbstractEntity
{
    private ?int $id = null;

    private string $name;

    private int $duration;

    private float $basePrice;

    private LazyLoadCollection $schedule;

    public function __construct(?int $id, string $name, int $duration, $basePrice, ?LazyLoadCollection $schedule = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->duration = $duration;
        $this->basePrice = (float) $basePrice;
        $this->schedule =
            $schedule ??
            new LazyLoadCollection($this, 'schedule');
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

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function getBasePrice(): float
    {
        return $this->basePrice;
    }

    public function setBasePrice(float $basePrice): self
    {
        $this->basePrice = $basePrice;
        return $this;
    }

    public function getSchedule(): ?LazyLoadCollection
    {
        return $this->schedule;
    }

    public function setSchedule(?LazyLoadCollection $schedule): self
    {
        $this->schedule = $schedule;
        return $this;
    }
}