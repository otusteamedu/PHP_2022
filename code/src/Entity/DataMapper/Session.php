<?php

namespace Ppro\Hw15\Entity\DataMapper;

class Session {
    /**
     * @var int
     */
    private $session_id;
    /**
     * @var int
     */
    private $movie_id;
    /**
     * @var int
     */
    private $hall_id;

    /**
     * @param int $session_id
     * @param int $movie_id
     * @param int $hall_id
     */
    public function __construct(
        int $session_id,
        int $movie_id,
        int $hall_id
    ) {
        $this->session_id = $session_id;
        $this->movie_id = $movie_id;
        $this->hall_id = $hall_id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->session_id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->session_id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getMovie(): int
    {
        return $this->movie_id;
    }

    /**
     * @param int $movieId
     * @return $this
     */
    public function setMovie(int $movieId): self
    {
        $this->movie_id = $movieId;
        return $this;
    }

    /**
     * @return string
     */
    public function getHall(): string
    {
        return $this->hall_id;
    }

    /**
     * @param int $hallId
     * @return $this
     */
    public function setHall(int $hallId): self
    {
        $this->hall_id = $hallId;
        return $this;
    }

    public function getAll(): array
    {
        return array(
          "session_id" => $this->session_id,
          "hall_id" => $this->hall_id,
          "movie_id" => $this->movie_id,
        );
    }
}