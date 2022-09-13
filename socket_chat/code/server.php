<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use \Mapaxa\SocketChatApp\Server\App;

try {
    $app = new App();
    $app->execute();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}