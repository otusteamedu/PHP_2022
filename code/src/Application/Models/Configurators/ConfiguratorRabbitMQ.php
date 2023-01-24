<?php

namespace Otus\Mvc\Application\Models\Configurators;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConfiguratorRabbitMQ
{
    public static function createdChannel()
    {
        $array_config = self::getConfiguration();

        $connection = new AMQPStreamConnection(
            $array_config['repository']['hostname'],
            $array_config['repository']['port'],
            $array_config['repository']['user'],
            $array_config['repository']['password']);
        $channel = $connection->channel();
        $channel->queue_declare('message_from_race', false, false, false, false);
        return $channel;
    }

    private static function getConfiguration()
    {
        if (!file_exists(__DIR__.'/../../../config/config.php')) {
            return false;
        } else {
            return include(__DIR__.'/../../../config/config.php');
        }
    }
}