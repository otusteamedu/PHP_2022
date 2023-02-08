<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw12\Map\Ticket;

use Nikcrazy37\Hw12\Map\IdentityMap;

class TicketCollection implements \Iterator
{
    private const TICKET_NAMESPACE = __NAMESPACE__ . "\Ticket";

    private int|null $position = null;
    private array $array = array();

    public function __construct()
    {
        $all = IdentityMap::getAll(self::TICKET_NAMESPACE);

        array_walk($all, function ($ticket, $key) {
            $intKey = str_replace(self::TICKET_NAMESPACE . ".", "", $key);
            $this->array[$intKey] = $ticket;
        });

        ksort($this->array);
    }

    public function rewind(): void
    {
        $this->position = null;
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->array[$this->position];
    }

    #[\ReturnTypeWillChange]
    public function key()
    {
        return $this->position;
    }

    #[\ReturnTypeWillChange]
    public function next()
    {
        if (is_null($this->position)) {
            $this->position = current($this->array)->getId();

            return $this->array[$this->position];
        }

        if ($next = next($this->array)) {
            $this->position = $next->getId();
        } else {
            $this->position = null;
        }

        return $this->array[$this->position];
    }

    public function valid(): bool
    {
        return isset($this->array[$this->position]);
    }

    /**
     * @return array
     */
    public function getCollection(): array
    {
        return $this->array;
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        $collection = $this->getCollection();
        array_walk($collection, function (&$element) {
            $element = $element->getAll();
        });

        return $collection;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return count($this->array);
    }

    /**
     * @param int $id
     * @return Ticket
     */
    public function get(int $id): Ticket
    {
        return $this->array[$id];
    }
}