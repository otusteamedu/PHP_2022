<?php

namespace Otus\App\Application\Entity;
use Otus\App\App;
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
        $channel->queue_declare('message_from_bank', false, false, false, false);
        return $channel;
    }

    private static function getConfiguration()
    {
        if (!file_exists('/data/mysite.local/src/Config/config.php')) {
            return false;
        } else {
            return include('/data/mysite.local/src/Config/config.php');
        }
    }
}