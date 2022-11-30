<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\MessageHandler;

use PhpAmqpLib\Message\AMQPMessage;
use Nikolai\Php\Infrastructure\Service\NotificationSenderInterface;

class ReportFormMessageHandler implements MessageHandlerInterface
{
    public function __construct(private NotificationSenderInterface $notificationSender) {}

    public function handler(AMQPMessage $amqpMessage): void
    {
        $body = json_decode($amqpMessage->body, true);

        echo 'Тело AMQP-сообщения:' . PHP_EOL;
        var_dump($body);
        echo PHP_EOL;

        $this->notificationSender->send($body) ? $amqpMessage->ack() : $amqpMessage->nack();
    }
}