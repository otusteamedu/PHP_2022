<?php

use Command\FindBookCommand;
use DI\Container;

class App
{
    private FindBookCommand $findBookCommand;

    public function __construct()
    {
        $container = new Container();
        $this->findBookCommand = $container->get(FindBookCommand::class);
    }

    public function run(): void
    {
        $searchWord = $_SERVER['argv'][1] ?? '';

        $this->findBookCommand->execute($searchWord);
    }
}