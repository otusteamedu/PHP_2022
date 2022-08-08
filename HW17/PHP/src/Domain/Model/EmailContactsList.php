<?php

declare(strict_types = 1);

namespace App\Domain\Model;

class EmailContactsList implements \IteratorAggregate
{
    protected array $storage;

    public function add(EmailContact $val) : void {
        $this->storage[] = $val;
    }

    public function set($key, EmailContact $val)
    {
        $this->storage[$key] = $val;
    }

    public function get($key) : EmailContact
    {
        return $this->storage[$key];
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->storage);
    }
}