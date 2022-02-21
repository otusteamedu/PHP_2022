<?php

use Command\PrintAlbumInfoCommand;
use DI\Container;

require 'vendor/autoload.php';

$container = new Container();
$command = $container->get(PrintAlbumInfoCommand::class);

try {
    if (!isset($argv[1])) {
        throw new InvalidArgumentException('Argument with album ID must be specified.');
    }

    $albumId = $argv[1];
    $command->execute($albumId);
} catch (Throwable $exception) {
    var_dump($exception->getMessage());
    var_dump($exception->getTraceAsString());
}
