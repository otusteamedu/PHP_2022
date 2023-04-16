<?php

namespace Otus\Task14\Factory\Contract;


interface ProductFactoryInterface
{
    public function make(): ProductInterface;
}