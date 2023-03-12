<?php

declare(strict_types=1);

$container = require __DIR__ . '/container.php';
$commands = require __DIR__ . '/../config/commands.php';

$arguments = $argv;

$fileName = \array_shift($arguments);
$commandName = \array_shift($arguments);

if ($commandName === 'list') {
    foreach ($commands as $name => $class) {
        print_r($name . ' => ' . $class::getDescription() . PHP_EOL);
    }
    return 0;
}

$commandClass = $commands[$commandName] ?? null;

if (\is_null($commandClass)) {
    throw new \RuntimeException('Команда ' . $commandName . ' не зарегистрирована');
}

if (
    \class_exists($commandClass)
    && \in_array(\App\Infrastructure\Command\CommandInterface::class, \class_implements($commandClass), true)
) {
    /** @var \App\Infrastructure\Command\AbstractCommand $command */
    $command = $container->get($commandClass);
    $command->setContainer($container);
    return new \App\ConsoleApp($command, $arguments);
}

throw new \RuntimeException('Некорректный класс ' . $commandClass);