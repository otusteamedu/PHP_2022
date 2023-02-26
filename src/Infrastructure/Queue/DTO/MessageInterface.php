<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Queue\DTO;

interface MessageInterface
{
    public function serialize(): string;

    public static function fromSerialize(string $serialize): self;
}