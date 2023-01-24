<?php

namespace Otus\Mvc\Application\Models\Entity\Producer;

use Otus\App\Domain\Models\Interface\SendInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Otus\Mvc\Application\Models\Configurators\ConfiguratorRabbitMQ;

class ApiQueue
{
    public $channel;

    public function __construct($new_id)
    {
        $connection = ConfiguratorRabbitMQ::createdChannel();
        $api_queue_message = "Гонка записана в календарь. Номер мероприятия $new_id!";
        $msg = new AMQPMessage($api_queue_message);
        $connection->basic_publish($msg, '', 'message_from_race');
    }
}