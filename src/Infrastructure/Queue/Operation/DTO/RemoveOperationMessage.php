<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Queue\Operation\DTO;

use DKozlov\Otus\Domain\Queue\MessageInterface;

class RemoveOperationMessage implements MessageInterface
{
    public function __construct(
        private int $id
    ) {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function serialize(): string
    {
        return serialize(['id' => $this->id]);
    }

    public static function fromSerialize(string $serialize): MessageInterface
    {
        $data = unserialize($serialize);

        return new self($data['id']);
    }
}