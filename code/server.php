<?php
declare(strict_types=1);


use Otus\SocketApp\Infrastructure\Cli\SocketServerCommand;


require __DIR__ . '/vendor/autoload.php';


try {
    $server = new SocketServerCommand();
    $server->execute();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
