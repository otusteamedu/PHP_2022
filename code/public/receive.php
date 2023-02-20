<?php

require '../vendor/autoload.php';

use Study\Cinema\Infrastructure\Rabbit\RabbitMQConnector;
use Study\Cinema\Application\Helper\DotEnv;
use Study\Cinema\Infrastructure\Service\Queue\RequestConsumer\RequestConsumer;
use Study\Cinema\Infrastructure\Service\Request\RequestService;
use Study\Cinema\Infrastructure\Service\Queue\EmailPublisher\EmailPublisher;
use Study\Cinema\Infrastructure\DB\DBConnection;

use Study\Cinema\Domain\Repository\RequestRepository;
use Study\Cinema\Domain\Repository\RequestStatusRepository;
use Study\Cinema\Domain\Repository\RequestTypeRepository;
use Study\Cinema\Domain\Repository\UserRepository;



(new DotEnv(__DIR__ . '/../.env'))->load();
$cn = new RabbitMQConnector();
$pdo = (new DBConnection())->getConnection();
$requestService = new RequestService();
$emailPublisher  = new EmailPublisher($cn);
$requestTypeRepository = new RequestTypeRepository($pdo);
$requestStatusRepository = new RequestStatusRepository($pdo);
$userRepository = new UserRepository($pdo);

$requestRepository = new RequestRepository($pdo, $userRepository, $requestStatusRepository, $requestTypeRepository );


$consumer = new RequestConsumer($cn,$requestService, $emailPublisher, $requestRepository);
$consumer->get();



