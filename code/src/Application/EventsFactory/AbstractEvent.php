<?php

declare(strict_types=1);

namespace Svatel\Code\Application\EventsFactory;

abstract class AbstractEvent
{
    private string $title;
    private array $body;

    public function __construct(string $title, array $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): array
    {
        return $this->body;
    }
}
