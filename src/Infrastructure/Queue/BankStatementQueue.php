<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Queue;

use Closure;
use DKozlov\Otus\Domain\Sender\SenderInterface;
use DKozlov\Otus\Domain\Sender\SenderMessage;
use DKozlov\Otus\Infrastructure\Queue\DTO\BankStatementMessage;
use DKozlov\Otus\Infrastructure\Queue\DTO\MessageInterface;
use PhpAmqpLib\Message\AMQPMessage;

class BankStatementQueue extends AbstractQueue
{
    private const QUEUE_NAME = 'bank_statement';

    private SenderInterface $sender;

    public function __construct(SenderInterface $sender) {
        parent::__construct();

        $this->sender = $sender;
    }

    public function publish(MessageInterface $message): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare(self::QUEUE_NAME);

        $message = new AMQPMessage($message->serialize());
        $channel->basic_publish($message, '', self::QUEUE_NAME);

        $channel->close();
    }

    public function receive(): void
    {
        $sender = $this->sender;
        $channel = $this->connection->channel();
        $channel->queue_declare(self::QUEUE_NAME);

        $callback = function ($message) use ($sender) {
              $dto = BankStatementMessage::fromSerialize($message->body);

              $message = new SenderMessage(
                  $dto->getEmail(),
                  'Банковская выписка',
                  'Банковская выписка с ' . $dto->getDateTo() . ' по ' . $dto->getDateFrom()
              );

              $sender->send($message);
        };

        $channel->basic_consume(self::QUEUE_NAME, '', false, false, false, false, $callback);

        while ($channel->is_open()) {
            $channel->wait();
        }
    }
}