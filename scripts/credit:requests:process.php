<?php

declare(strict_types=1);

defined('PUBLIC_PATH') || define('PUBLIC_PATH', __DIR__);
defined('BASE_PATH') || define('BASE_PATH', dirname(PUBLIC_PATH).'/');
defined('APP_PATH') || define('APP_PATH', realpath(BASE_PATH.'/code'));

use App\Application\Service\CreditRequestProcessor;
use DI\ContainerBuilder;

require_once dirname(__DIR__).'/vendor/autoload.php';

try {
    $builder = new ContainerBuilder();
    $builder->addDefinitions(APP_PATH.'/config.php');
    $container = $builder->build();

    $amqpConnection = $container->get('amqp');
    $memcached = $container->get('memcached');

    $processor = new CreditRequestProcessor($amqpConnection, $memcached);

    while (true) {
        $processor->listen();
    }

} catch (Exception $e) {
    echo $e->getMessage()."\n"."Trace: ".$e->getTraceAsString()."\n";
}