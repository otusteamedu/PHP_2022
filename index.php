<?php

declare(strict_types=1);

use DI\Container;
use Command\CheckEmailCommand;
use Kirillov\EmailValidator\Storage\HostsStorage;
use Kirillov\EmailValidator\Validator\EmailValidator;

require 'vendor/autoload.php';

$container = new Container();
$command = $container->get(CheckEmailCommand::class);

try {
    $command->execute('k.kirillov@itglobal.com');
    $command->execute('k.kirillov@mail.com');
    $command->execute('not an email');
    $command->execute('');
} catch (Exception $exception) {
    var_dump($exception->getMessage());
}