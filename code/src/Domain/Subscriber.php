<?php

declare(strict_types=1);

namespace Svatel\Code\Domain;

final class Subscriber
{
    private ?int $id;
    private ?int $eventId;
    private ?array $users;

    public function __construct(?int $id = null, ?int $eventId = null, ?array $users = null)
    {
        $this->id = $id;
        $this->eventId = $eventId;
        $this->users = $users;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventId(): ?int
    {
        return $this->eventId;
    }

    public function setEventId(?int $eventId): void
    {
        $this->eventId = $eventId;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUsers(): array
    {
        return $this->users;
    }

    public function setUser(string $user): void
    {
        $this->users[] = $user;
    }
}
