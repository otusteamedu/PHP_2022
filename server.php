<?php
declare(strict_types=1);

use Qween\Php2022\App\Config;
use Qween\Php2022\App\Logger;
use Qween\Php2022\App\Server;

require __DIR__ . '/vendor/autoload.php';

try {
    $config = new Config();
    $logger = new Logger();
    $socket = new \Qween\Php2022\App\Socket($config->getParam('SOCKET_FILE'));
    $app = new Server($logger, $socket);
    $app->execute();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
