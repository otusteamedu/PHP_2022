<?php

namespace Ppro\Hw27\Consumer\Services;

use PhpAmqpLib\Message\AMQPMessage;
use Ppro\Hw27\Consumer\Application\Queue;
use Ppro\Hw27\Consumer\Application\Registry;
use Ppro\Hw27\Consumer\Entity\MailDto;
use Ppro\Hw27\Consumer\Queue\Broker;
use Ppro\Hw27\Consumer\Validators\MailValidator;

class RabbitBankProcessing
{
    private array $requestBody = [];

    public function __construct(array $requestBody)
    {
        $this->requestBody = $requestBody;
    }

    public static function bankAccountStatementProcessing(AMQPMessage $msg)
    {
        echo PHP_EOL.'[x] Received '.$msg->body.PHP_EOL;
        $requestBody = json_decode($msg->body, true);

        //обработка
        $bankProcessing = new self($requestBody);
        $bankProcessing->requestProcessing();

        //ставим в очередь на отправку
        $bankProcessing->mailQueueSending();
    }

    private function requestProcessing()
    {
        echo '[x] Processing -> account request processing start'.PHP_EOL;
        $processingTime = rand(1,10);
        sleep($processingTime);//Processing
        $this->requestBody['msg'] = "Текущее состояние счета:". rand(1000,10000)." ₽";
        echo '[x] Processing -> account request processing finished by (s)'.$processingTime.PHP_EOL;
    }

    private function mailQueueSending()
    {
        echo '[x] Processing -> sendToMailQueue'.PHP_EOL;
        $mail = new MailDto($this->requestBody, new MailValidator());
        $mail->validate();

        $queueBrokerName = Registry::instance()->getConf()->get('QUEUE_BROKER');
        $queueBroker = new Broker($queueBrokerName);
        $queueBroker->getQueue()->sendMessage($mail,'MailEvent');
    }
}