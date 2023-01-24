<?php

namespace Otus\Mvc\Application\Models\Entity\Producer;

use Otus\Mvc\Application\Models\Configurators\ConfiguratorRabbitMQ;
use Otus\Mvc\Application\Models\Entity\Messenger\MailMessenger;
use Otus\Mvc\Domain\Models\Interface\SendInterface;
use PhpAmqpLib\Message\AMQPMessage;

class RaceSender implements SendInterface
{
    public $channel;

    public function generateMessage()
    {
        //Создаем очередь
        $connection = ConfiguratorRabbitMQ::createdChannel();

        $email = $_SESSION['email'];

        //Отправляем сообщение в очередь
        $bank_message = "Отправим на $email подтверждение регистрации";
        $msg = new AMQPMessage($bank_message);
        $connection->basic_publish($msg, '', 'message_from_race');

        //Уведомляем клиента письмом
        $email_message = new MailMessenger();
        $email_message->send($email);
    }
}