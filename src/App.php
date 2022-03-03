<?php

use Command\CheckEmailCommand;
use DI\Container;

class App
{
    private CheckEmailCommand $checkEmailCommand;

    public function __construct()
    {
        $container = new Container();
        $this->checkEmailCommand = $container->get(CheckEmailCommand::class);
    }

    public function run(string $email = '')
    {
        try {
            !empty($email) ? $this->checkEmailCommand->execute($email) : $this->checkEmailCommand->execute();
        } catch (Exception $exception) {
            echo $exception->getMessage() . PHP_EOL;
        }
    }
}