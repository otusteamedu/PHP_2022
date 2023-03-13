<?php

namespace Ppro\Hw27\App\Queue\Config;

use Ppro\Hw27\App\Application\Registry;

class RabbitmqConfig implements QueueConfigInterface
{
    private static $instance = null;
    private array $conf = [];
    private function __construct()
    {
        $this->conf = [
          'RABBITMQ_HOST' => Registry::instance()->getConf()->get('RABBITMQ_DEFAULT_HOST'),
          'RABBITMQ_PORT' => Registry::instance()->getConf()->get('RABBITMQ_DEFAULT_PORT'),
          'RABBITMQ_USER' => Registry::instance()->getEnvironment()->get('RABBITMQ_USER'),
          'RABBITMQ_PASSWORD' => Registry::instance()->getEnvironment()->get('RABBITMQ_PASSWORD'),
        ];
    }

    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConfig():array
    {
        return $this->conf;
    }
}