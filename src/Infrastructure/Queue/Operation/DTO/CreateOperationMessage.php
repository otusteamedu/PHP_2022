<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Queue\Operation\DTO;

use DateTimeInterface;
use DKozlov\Otus\Domain\Queue\MessageInterface;

class CreateOperationMessage implements MessageInterface
{
    public function __construct(
        private int $id,
        private string $person,
        private float $amount,
        private DateTimeInterface $date,
        private ?DateTimeInterface $createdAt = null
    ) {
    }

    public function serialize(): string
    {
        return serialize([
            'id' => $this->id,
            'person' => $this->person,
            'amount' => $this->amount,
            'date' => $this->date,
            'createdAt' => $this->createdAt
        ]);
    }

    public static function fromSerialize(string $serialize): self
    {
        $data = unserialize($serialize);

        return new self(
            (int) $data['id'],
            $data['person'],
            (float) $data['amount'],
            $data['date'],
            $data['createdAt']
        );
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
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }
}