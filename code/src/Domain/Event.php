<?php

declare(strict_types=1);

namespace Svatel\Code\Domain;

final class Event
{
    private ?int $id;
    private ?string $type;
    private ?array $body;

    public function __construct(
        ?int $id = null,
        ?string $type = null,
        ?array $body = null
    ) {
        $this->id = $id;
        $this->type = $type;
        $this->body = $body;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBody(): ?array
    {
        return $this->body;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setBody(array $body): void
    {
        $this->body = $body;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
