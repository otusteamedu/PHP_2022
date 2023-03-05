<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Operation;

use DateTime;
use DateTimeInterface;

class Operation
{
    private ?DateTimeInterface $createdAt;

    public function __construct(
        private int $id,
        private string $person,
        private float $amount,
        private DateTimeInterface $date,
        ?DateTimeInterface $createdAt = null
    ) {
        $this->createdAt = $createdAt ?: new DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPerson(): string
    {
        return $this->person;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param string $person
     * @return Operation
     */
    public function setPerson(string $person): Operation
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @param float $amount
     * @return Operation
     */
    public function setAmount(float $amount): Operation
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param DateTimeInterface $date
     * @return Operation
     */
    public function setDate(DateTimeInterface $date): Operation
    {
        $this->date = $date;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'person' => $this->getPerson(),
            'amount' => $this->getAmount(),
            'date' => $this->getDate()->format('Y-m-d H:i:s'),
            'createdAt' => ($this->getCreatedAt()) ? $this->createdAt->format('Y-m-d H:i:s') : null
        ];
    }
}