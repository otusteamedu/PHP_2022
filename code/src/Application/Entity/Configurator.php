<?php

namespace Otus\App\Application\Entity;

use Otus\App\App;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Configurator
{
    /**
     * Create notification channel
     * @return mixed
     */
    public static function createdChannel()
    {
        $array_config = self::getConfiguration();

        $connection = new AMQPStreamConnection(
            $array_config['repository']['hostname'],
            $array_config['repository']['port'],
            $array_config['repository']['user'],
            $array_config['repository']['password']
        );

        $channel = $connection->channel();
        $channel->queue_declare('message_from_bank', false, false, false, false);

        return $channel;
    }

    /**
     * Get config
     * @return array
     */
    private static function getConfiguration(): array
    {
        $configuration = App::getConfig();
        return $configuration;
    }
}
