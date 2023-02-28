<?php

declare(strict_types=1);

namespace App\Entity;

class Ticket
{
    private int $id;

    private int $scheduleId;

    private int $price;

    private int $clientId;

    private int $place;

    private string $purchaseTime;

    /**
     * @param int $id
     * @param int $scheduleId
     * @param int $price
     * @param int $clientId
     * @param int $place
     * @param string $purchaseTime
     */
    public function __construct(int $id, int $scheduleId, int $price, int $clientId, int $place, string $purchaseTime)
    {
        $this->id = $id;
        $this->scheduleId = $scheduleId;
        $this->price = $price;
        $this->clientId = $clientId;
        $this->place = $place;
        $this->purchaseTime = $purchaseTime;
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
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->clientId;
    }

    /**
     * @param int $clientId
     */
    public function setClientId(int $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @return int
     */
    public function getPlace(): int
    {
        return $this->place;
    }

    /**
     * @param int $place
     */
    public function setPlace(int $place): void
    {
        $this->place = $place;
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
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getScheduleId(): int
    {
        return $this->scheduleId;
    }

    /**
     * @param int $scheduleId
     */
    public function setScheduleId(int $scheduleId): void
    {
        $this->scheduleId = $scheduleId;
    }

    /**
     * @return string
     */
    public function getPurchaseTime(): string
    {
        return $this->purchaseTime;
    }
}
