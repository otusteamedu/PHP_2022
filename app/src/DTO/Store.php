<?php

namespace HW10\App\DTO;

class Store
{
    private string $name;

    private int $store;

    public function __construct(string $name, int $store)
    {
        $this->name = $name;
        $this->store = $store;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStore(): int
    {
        return $this->store;
    }
}
