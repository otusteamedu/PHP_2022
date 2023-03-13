<?php

namespace Ppro\Hw27\App\Queue;

use Ppro\Hw27\App\Exceptions\AppException;

class Broker
{
    private QueueInterface $queue;

    public function __construct(string $broker)
    {
        $brokerClass = __NAMESPACE__ . '\\' . ucfirst(strtolower($broker)) . "Queue";
        $brokerConfig = __NAMESPACE__ . '\\Config\\' . ucfirst(strtolower($broker)) . "Config";
        if (!class_exists($brokerClass))
            throw new AppException('Queue broker class not found');
        $this->queue = new $brokerClass();
        if (class_exists($brokerConfig))
            $this->queue->setConfig($brokerConfig::instance()->getConfig());
    }

    public function getQueue(): QueueInterface
    {
        return $this->queue;
    }
}