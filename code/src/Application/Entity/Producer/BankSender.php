<?php

namespace Otus\App\Application\Entity\Producer;

use Otus\App\Application\Entity\Configurator;
use Otus\App\Application\Entity\Messenger\MailMessenger;
use Otus\App\Application\Services\MessageForSend;
use Otus\App\Domain\Models\Interface\SendInterface;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Send email to client
 */
class BankSender implements SendInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $connection = Configurator::createdChannel();
        $array_for_message = BankSender::sendMessage();

        $email = current($array_for_message);
        $array_date = array_slice($array_for_message, 1, 2);
        $data_start = current($array_date);
        $data_end = end($array_date);
        $bank_message = "Отправляем на email '$email' выписку за период с $data_start по $data_end ...";

        $msg = new AMQPMessage($bank_message);
        $connection->basic_publish($msg, '', 'message_from_bank');
        $email_message = new MailMessenger();
        $email_message->send($email);
    }

    /**
     * @return array|void
     */
    public static function sendMessage()
    {
        $created_message = new MessageForSend();
        $bank_message = $created_message->create();
        return $bank_message;
    }
}
