<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Otus\SocketApp\Entity\Client;

try {
    $app = new Client();
    $app->execute();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
