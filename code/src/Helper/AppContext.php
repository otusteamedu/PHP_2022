<?php

namespace Ppro\Hw7\Helper;

class AppContext
{
    private array $context = [];

    public function setValue(string $key, $value): void
    {
        $this->context[$key] = $value;
    }

    public function getValue(string $key, mixed $defaultValue = "")
    {
        return $this->context[$key];
    }

    public function getContext(): array
    {
        return $this->context;
    }
}