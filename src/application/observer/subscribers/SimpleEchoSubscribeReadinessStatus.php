<?php

namespace Mselyatin\Patterns\application\observer\subscribers;

use Mselyatin\Patterns\domain\interfaces\models\BakeryInterface;
use Mselyatin\Patterns\domain\interfaces\observer\PublisherInterface;
use Mselyatin\Patterns\domain\interfaces\observer\SubscriberInterface;

class SimpleEchoSubscribeReadinessStatus implements SubscriberInterface
{
    /**
     * @param PublisherInterface|BakeryInterface $publisher
     * @return void
     */
    public function notify(PublisherInterface $publisher): void
    {
        $currentStatusText = $publisher->getStatus()->getValue();
        echo 'Статус продукта изменился на: ' . $currentStatusText . PHP_EOL;
    }
}