<?php

declare(strict_types=1);

namespace Nikolai\Php\Domain\Entity;

use Nikolai\Php\Domain\Collection\LazyLoadCollection;

class Schedule extends AbstractEntity
{
    private ?int $id = null;

    private string $beginSession;

    private Film $film;

    private CinemaHall $cinemaHall;

    private LazyLoadCollection $ticket;

    public function __construct(?int $id, \DateTime|string $beginSession, Film $film, CinemaHall $cinemaHall, ?LazyLoadCollection $ticket = null)
    {
        $this->id = $id;
        $this->beginSession = $beginSession instanceof \DateTime ? $beginSession->format('m/d/Y H:i:s') : $beginSession;
        $this->film = $film;
        $this->cinemaHall = $cinemaHall;
        $this->ticket =
            $ticket ??
            new LazyLoadCollection($this, 'ticket');
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

    public function getBeginSession(): \DateTime|string
    {
        return $this->beginSession;
    }

    public function setBeginSession(\DateTime|string $beginSession): self
    {
        $this->beginSession = $beginSession instanceof \DateTime ? $beginSession->format('m/d/Y H:i:s') : $beginSession;
        return $this;
    }

    public function getFilm(): Film
    {
        return $this->film;
    }

    public function setFilm(Film $film): self
    {
        $this->film = $film;
        return $this;
    }

    public function getCinemaHall(): CinemaHall
    {
        return $this->cinemaHall;
    }

    public function setCinemaHall(CinemaHall $cinemaHall): self
    {
        $this->cinemaHall = $cinemaHall;
        return $this;
    }

    public function getTicket(): ?LazyLoadCollection
    {
        return $this->ticket;
    }

    public function setTicket(?LazyLoadCollection $ticket): self
    {
        $this->ticket = $ticket;
        return $this;
    }
}