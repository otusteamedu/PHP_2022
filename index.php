<?php

declare(strict_types=1);

use DI\Container;
use Command\CheckEmailCommand;

require 'vendor/autoload.php';

$container = new Container();
$command = $container->get(CheckEmailCommand::class);

try {
    isset ($argv[1]) ? $command->execute($argv[1]) : $command->execute();
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
