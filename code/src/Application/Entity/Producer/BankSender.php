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
        $connection  = Configurator::createdChannel();

        $bankMessage = $this->createMessage();
        $email       = $bankMessage->getEmail();
        $data_start  = $bankMessage->getDateStartStr();
        $data_end    = $bankMessage->getDateEndStr();
        $bankMessageText = "Отправляем на email '$email' выписку за период с $data_start по $data_end ...";

        $msg = new AMQPMessage($bankMessageText);
        $connection->basic_publish($msg, '', 'message_from_bank');
        $email_message = new MailMessenger();
        $email_message->send($email);
    }

    /**
     * @return array|void
     */
    public function createMessage(): BankMessage
    {
        $messageForSend = new MessageForSend();
        $bankMessage = $messageForSend->create();

        return $bankMessage;
    }
}
