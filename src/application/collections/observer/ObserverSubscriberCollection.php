<?php

namespace Mselyatin\Patterns\application\collections\observer;

use Mselyatin\Patterns\domain\interfaces\collections\CollectionInterface;
use Mselyatin\Patterns\domain\interfaces\observer\SubscriberInterface;

class ObserverSubscriberCollection implements CollectionInterface
{
    private array $items = [];

    /**
     * @param $value
     * @param null $key
     * @return ObserverSubscriberCollection
     */
    public function add($value, $key = null): self
    {
        if (null === $key) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }

        return $this;
    }

    /**
     * @param $key
     * @return ObserverSubscriberCollection
     */
    public function remove($key): self
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        }

        return $this;
    }

    /**
     * @param $key
     * @return SubscriberInterface|null
     */
    public function get($key): ?SubscriberInterface
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