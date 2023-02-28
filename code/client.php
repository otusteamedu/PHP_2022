<?php
declare(strict_types=1);


use Otus\SocketApp\Infrastructure\Cli\SocketClientCommand;


require __DIR__ . '/vendor/autoload.php';


try {
    $client = new SocketClientCommand();
    $client->execute();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
