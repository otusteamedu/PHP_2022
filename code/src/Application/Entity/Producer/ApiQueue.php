<?php

namespace Otus\App\Application\Entity\Producer;

use Otus\App\Domain\Models\Interface\SendInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Otus\App\Application\Entity\Configurator;

class ApiQueue
{
    public $channel;

    public function __construct($new_id)
    {
        $connection = Configurator::createdChannel();
        $api_queue_message = "Заявка принята. Номер $new_id. Чтобы проверить состояние http://mysite.local/api/v1/enquiry/$new_id";
        $msg = new AMQPMessage($api_queue_message);
        $connection->basic_publish($msg, '', 'message_from_bank');
    }
}