<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\MessageHandler;

use PhpAmqpLib\Message\AMQPMessage;

interface MessageHandlerInterface
{
    public function handler(AMQPMessage $amqpMessage): void;
}