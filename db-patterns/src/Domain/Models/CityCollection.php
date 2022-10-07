<?php

namespace AVasechkin\DataMapper\Domain\Models;

class CityCollection
{
    private array $items = [];

    public function add(City $city): self
    {
        $this->items[] = $city;
        return $this;
    }

    /**
     * @return City[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
