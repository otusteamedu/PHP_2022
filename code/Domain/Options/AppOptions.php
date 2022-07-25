<?php

declare(strict_types=1);

namespace App\Domain\Options;

use InvalidArgumentException;

class AppOptions
{
    private string $type;

    public function __construct(private readonly array $values)
    {
        $this->assertValidType($this->values);

        $this->type = $this->values[1];
    }

    private function assertValidType(array $values): void
    {
        if (!isset($values[1])) {
            throw new InvalidArgumentException('Empty script parameters.');
        }

        if (!in_array($values[1], ['server', 'client'])) {
            throw new InvalidArgumentException('Wrong script parameters.');
        }
    }

    public function getAppType(): string
    {
        return $this->type;
    }
}