<?php

require '../vendor/autoload.php';

use Study\Cinema\Infrastructure\Rabbit\RabbitMQConnector;
use Study\Cinema\Application\Helper\DotEnv;
use Study\Cinema\Infrastructure\Service\Queue\StatementConsumer\StatementConsumer;
use Study\Cinema\Infrastructure\Service\Statement\StatementService;
use Study\Cinema\Infrastructure\Service\Queue\EmailPublisher\EmailPublisher;
(new DotEnv(__DIR__ . '/../.env'))->load();

$cn = new RabbitMQConnector();
$statementService = new StatementService();
$emailPublisher  = new EmailPublisher($cn);

$consumer = new StatementConsumer($cn,$statementService, $emailPublisher );
$consumer->get();



