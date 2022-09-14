<?php

namespace Mselyatin\Patterns\domain\collections\valueObjects;

use Mselyatin\Patterns\domain\interfaces\collections\CollectionInterface;
use Mselyatin\Patterns\domain\interfaces\valueObjects\CompositionBakeryItemInterface;

/**
 * Коллекция для состава хлебобулочного изделия
 */
class CompositionBakeryCollection implements CollectionInterface
{
    private array $items = [];

    /**
     * @param $value
     * @param $key
     * @return void
     */
    public function add($value, $key = null): void
    {
        if (null === $key) {
            $this->items[] = $value;
            return;
        }

        $this->items[$key] = $value;
    }

    /**
     * @param $key
     * @return void
     */
    public function remove($key): void
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        }
    }

    /**
     * @param $key
     * @return CompositionBakeryItemInterface|null
     */
    public function get($key): ?CompositionBakeryItemInterface
    {
        return $this->items[$key] ?? null;
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return count($this->items);
    }

    /**
     * @return mixed
     */
    public function current(): mixed
    {
       return current($this->items);
    }

    /**
     * @return mixed
     */
    public function next(): mixed
    {
        return next($this->items);
    }

    /**
     * @return mixed
     */
    public function prev(): mixed
    {
       return prev($this->items);
    }

    /**
     * @param $value
     * @param null $key
     * @return bool
     */
    public function hasItem($value, $key = null): bool
    {
        if (null === $key) {
            return in_array($value, $this->items);
        }

        return isset($this->items[$key]);
    }
}