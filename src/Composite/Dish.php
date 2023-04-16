<?php

namespace Otus\Task14\Composite;

abstract class Dish
{
    public function add(Dish $component)
    {
        throw new \Exception('Method "add" not implemented');
    }

    public function getTogether(){
        throw new \Exception('Method "getTogether" not implemented');
    }
}