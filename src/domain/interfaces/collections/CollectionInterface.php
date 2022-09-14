<?php

namespace Mselyatin\Patterns\domain\interfaces\collections;

interface CollectionInterface
{
    public function add($value, $key = null);
    public function remove($key);
    public function get($key);
    public function hasItem($value, $key = null);

    public function size(): int;
    public function current();
    public function next();
    public function prev();
}