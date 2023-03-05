<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Queue\Operation;

use DKozlov\Otus\Domain\Operation\OperationMapperInterface;
use DKozlov\Otus\Exception\ConnectionTimeoutException;
use DKozlov\Otus\Infrastructure\Queue\AbstractQueue;
use DKozlov\Otus\Infrastructure\Queue\Operation\DTO\RemoveOperationMessage;
use PhpAmqpLib\Message\AMQPMessage;

class RemoveOperationQueue extends AbstractQueue
{
    protected string $queue = 'remove_operation_queue';

    public function __construct(
        private readonly OperationMapperInterface $operationMapper
    ) {
    }

    protected function callback(AMQPMessage $message): void
    {
        $operationMessage = RemoveOperationMessage::fromSerialize($message->getBody());

        try {
            $this->operationMapper->remove((string) $operationMessage->getId());

            $success = true;
        } catch (ConnectionTimeoutException) {
            $success = false;
        }

        $channel = $message->getChannel();

        if ($channel) {
            $this->sendMessage(
                $channel,
                json_encode(['success' => $success], JSON_THROW_ON_ERROR),
                $message->get('reply_to'),
                ['correlation_id' => $message->get('correlation_id')]
            );
        }
    }
}