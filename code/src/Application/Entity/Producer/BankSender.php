<?php

namespace Otus\App\Application\Entity\Producer;

use Otus\App\Application\Entity\ConfiguratorRabbitMQ;
use Otus\App\Application\Entity\Messenger\MailMessenger;
use Otus\App\Application\Services\MessageForSend;
use Otus\App\Domain\Models\Interface\SendInterface;
use PhpAmqpLib\Message\AMQPMessage;

class BankSender implements SendInterface
{
    public $channel;

    public function __construct()
    {
        $connection = ConfiguratorRabbitMQ::createdChannel();
        $array_for_message = BankSender::generateMessage();
        $email = $array_for_message[0];
        $data_start = $array_for_message[1];
        $data_end = $array_for_message[2];
        $bank_message = "Отправим на $email выписку за период $data_start - $data_end ";
        $msg = new AMQPMessage($bank_message);
        $connection->basic_publish($msg, '', 'message_from_bank');
        $email_message = new MailMessenger();
        $email_message->send($email);
    }

    public static function generateMessage()
    {
        $created_message = new MessageForSend();
        $bank_message = $created_message->create();
        return $bank_message;
    }
}