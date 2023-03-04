<?php

declare(strict_types=1);

namespace App\Entity;

use Closure;

class Client
{
    private int $id;

    private string $email;

    private string $phone;

    /**
     * @var Ticket[] $tickets
     */
    private array $tickets;

    private Closure $reference;

    private array $state;

    public function __construct(int $id, string $email, string $phone)
    {
        $this->id = $id;
        $this->email = $email;
        $this->phone = $phone;
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
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return array
     */
    public function getTickets(): array
    {
        if (!isset($this->tickets)) {
            $reference = $this->reference;
            $this->tickets = $reference();
        }
        return $this->tickets;
    }

    /**
     * @param Closure $reference
     */
    public function setReference(Closure $reference): void
    {
        $this->reference = $reference;
    }

    /**
     * @return array
     */
    public function getState(): array
    {
        return $this->state;
    }

    /**
     * @param array $state
     */
    public function setState(array $state): void
    {
        $this->state = $state;
    }
}
