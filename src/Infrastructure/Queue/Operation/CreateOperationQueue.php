<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Queue\Operation;

use DKozlov\Otus\Domain\Operation\Operation;
use DKozlov\Otus\Domain\Operation\OperationMapperInterface;
use DKozlov\Otus\Exception\ConnectionTimeoutException;
use DKozlov\Otus\Infrastructure\Queue\AbstractQueue;
use DKozlov\Otus\Infrastructure\Queue\Operation\DTO\CreateOperationMessage;
use PhpAmqpLib\Message\AMQPMessage;

class CreateOperationQueue extends AbstractQueue
{
    protected string $queue = 'create_operation_queue';

    public function __construct(
        private readonly OperationMapperInterface $operationMapper
    ) {
    }

    protected function callback(AMQPMessage $message): void
    {
        $operationMessage = CreateOperationMessage::fromSerialize($message->getBody());

        try {
            $this->createOperation($operationMessage);

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

    /**
     * @throws ConnectionTimeoutException
     */
    protected function createOperation(CreateOperationMessage $message): void
    {
        $operation = new Operation(
            $message->getId(),
            $message->getPerson(),
            $message->getAmount(),
            $message->getDate(),
            $message->getCreatedAt()
        );

        $this->operationMapper->save($operation);
    }
}