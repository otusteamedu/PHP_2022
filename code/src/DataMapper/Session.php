<?php

declare(strict_types = 1);

namespace Study\Cinema\DataMapper;

class Session {


    private ?int $id;
    private int $days_type_id;
    private int $hall_id;
    private int $movie_id;
    private float $price;
    private string $started_at;

    /**
     * @param ?int $id
     * @param int $hall_id
     * @param int $movie_id
     * @param int $days_type_id
     * @param float $price
     * @param string $started_at
     */
    public function __construct(
        ?int $id,
        int $hall_id,
        int $movie_id,
        int $days_type_id,
        float $price,
        string $started_at
    )
    {
        $this->id = $id;
        $this->hall_id = $hall_id;
        $this->movie_id = $movie_id;
        $this->days_type_id = $days_type_id;
        $this->price = $price;
        $this->started_at = $started_at;

    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return Session
     */
    public function setId(?int $id): Session
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getDaysTypeId(): int
    {
        return $this->days_type_id;
    }

    /**
     * @param int $days_type_id
     * @return Session
     */
    public function setDaysTypeId(int $days_type_id): Session
    {
        $this->days_type_id = $days_type_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getHallId(): int
    {
        return $this->hall_id;
    }

    /**
     * @param int $hall_id
     * @return Session
     */
    public function setHallId(int $hall_id): Session
    {
        $this->hall_id = $hall_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movie_id;
    }

    /**
     * @param int $movie_id
     * @return Session
     */
    public function setMovieId(int $movie_id): Session
    {
        $this->movie_id = $movie_id;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Session
     */
    public function setPrice(float $price): Session
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getStartedAt(): string
    {
        return $this->started_at;
    }

    /**
     * @param string $started_at
     * @return Session
     */
    public function setStartedAt(string $started_at): Session
    {
        $this->started_at = $started_at;
        return $this;
    }

}