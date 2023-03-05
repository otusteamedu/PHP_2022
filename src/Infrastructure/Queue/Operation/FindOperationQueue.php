<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Queue\Operation;

use DKozlov\Otus\Domain\Operation\OperationMapperInterface;
use DKozlov\Otus\Exception\ConnectionTimeoutException;
use DKozlov\Otus\Exception\EntityNotFoundException;
use DKozlov\Otus\Infrastructure\Queue\AbstractQueue;
use DKozlov\Otus\Infrastructure\Queue\Operation\DTO\FindOperationMessage;
use Exception;
use PhpAmqpLib\Message\AMQPMessage;

class FindOperationQueue extends AbstractQueue
{
    protected string $queue = 'find_operation_queue';

    public function __construct(
        private readonly OperationMapperInterface $operationMapper
    ) {
    }

    protected function callback(AMQPMessage $message): void
    {
        $operationMessage = FindOperationMessage::fromSerialize($message->getBody());

        try {
            $operation = $this->operationMapper->find($operationMessage->getId());

            $result = $operation->toArray();
        } catch (EntityNotFoundException) {
            $result = [];
        } catch (ConnectionTimeoutException|Exception) {
            $result = null;
        }

        $channel = $message->getChannel();

        if ($channel) {
            $this->sendMessage(
                $channel,
                json_encode(['result' => $result], JSON_THROW_ON_ERROR),
                $message->get('reply_to'),
                ['correlation_id' => $message->get('correlation_id')]
            );
        }
    }
}