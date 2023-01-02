<?php

namespace HW10\App\DTO;

use HW10\App\Interfaces\StoreDTOInterface;

class StoreDTO implements StoreDTOInterface
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
