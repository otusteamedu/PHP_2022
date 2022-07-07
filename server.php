<?php
declare(strict_types=1);

use Qween\Php2022\App\Config;
use Qween\Php2022\App\Logger;
use Qween\Php2022\App\Server;

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new Server(new Logger(), new \Qween\Php2022\App\Socket((new Config())->getParam('SOCKET_FILE')));
    $app->execute();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
