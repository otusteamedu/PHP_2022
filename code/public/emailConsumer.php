<?php

require '../vendor/autoload.php';

use Study\Cinema\Infrastructure\Rabbit\RabbitMQConnector;
use Study\Cinema\Application\Helper\DotEnv;
use Study\Cinema\Infrastructure\Service\Queue\EmailConsumer\EmailConsumer;

(new DotEnv(__DIR__ . '/../.env'))->load();

$cn = new RabbitMQConnector();

$consumer = new EmailConsumer($cn);
$consumer->get();



