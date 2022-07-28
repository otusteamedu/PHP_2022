<?php

use DI\Container;
use Domain\Contract\StorageInterface;

class App
{
    private StorageInterface $storage;

    public function __construct()
    {
        $container = new Container();
        $this->storage = $container->get(StorageInterface::class);
    }

    public function run(): void
    {

    }
}
