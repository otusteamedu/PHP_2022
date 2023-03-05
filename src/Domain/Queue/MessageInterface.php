<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Queue;

interface MessageInterface
{
    public function serialize(): string;

    public static function fromSerialize(string $serialize): self;
}