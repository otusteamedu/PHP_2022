<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw12\Model;

use Nikcrazy37\Hw12\Core\Entity\Entity;

class Ticket implements Entity
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $price;

    /**
     * @var int
     */
    private int $seat;

    /**
     * @var int
     */
    private int $sessionId;

    /**
     * @param int $id
     * @param int $price
     * @param int $seat
     * @param int $sessionId
     */
    public function __construct(
        int $id,
        int $price,
        int $seat,
        int $sessionId,
    )
    {
        $this->id = $id;
        $this->price = $price;
        $this->seat = $seat;
        $this->sessionId = $sessionId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return $this
     */
    public function setPrice(int $price): static
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getSeat(): int
    {
        return $this->seat;
    }

    /**
     * @param int $seat
     * @return $this
     */
    public function setSeat(int $seat): static
    {
        $this->seat = $seat;
        return $this;
    }

    /**
     * @return int
     */
    public function getSessionId(): int
    {
        return $this->sessionId;
    }

    /**
     * @param int $sessionId
     * @return $this
     */
    public function setSessionId(int $sessionId): static
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return array(
            "id" => $this->id,
            "price" => $this->price,
            "seat" => $this->seat,
            "sessionId" => $this->sessionId,
        );
    }
}