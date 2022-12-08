<?php

namespace Ppro\Hw12\Helpers;

class AppContext
{
    private array $context = [];

    public function setValue(string $key, $value): void
    {
        $this->context[$key] = $value;
    }

    public function setValueMulti(array $params = []): void
    {
        array_walk($params,fn($val,$key) => $this->context[$key] = $val);
    }

    public function getValue(string $key, mixed $defaultValue = "")
    {
        return $this->context[$key] ?: $defaultValue;
    }

    public function getContext(): array
    {
        return $this->context;
    }
}