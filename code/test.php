<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$config = new \Otus\SocketApp\Entity\Config();

echo $config->getParam('SOCKET_FILE');
