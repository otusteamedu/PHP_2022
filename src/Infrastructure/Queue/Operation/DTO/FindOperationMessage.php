<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Queue\Operation\DTO;

use DKozlov\Otus\Domain\Queue\MessageInterface;

class FindOperationMessage implements MessageInterface
{
    public function __construct(
        private int $id
    ) {
    }

    public function serialize(): string
    {
        return serialize(['id' => $this->id]);
    }

    public static function fromSerialize(string $serialize): self
    {
        $data = unserialize($serialize);

        return new self($data['id']);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}