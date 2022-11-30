<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Service;

use Nikolai\Php\Application\Dto\Input\ReportFormDto;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class PublishMessageService implements PublishMessageInterface
{
    public function __construct(
        private AMQPStreamConnection $connection,
        private string $queue,
        private string $exchange
    ) {}

    public function publishMessage(ReportFormDto $reportFormDto): bool
    {
        try {
            $channel = $this->connection->channel();
            $channel->queue_declare($this->queue, false, true, false, false);
            $channel->exchange_declare($this->exchange, AMQPExchangeType::DIRECT, false, true, false);
            $channel->queue_bind($this->queue, $this->exchange);

            $amqpMessage = new AMQPMessage(json_encode($reportFormDto), array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
            $channel->basic_publish($amqpMessage, $this->exchange);

            $channel->close();
            $this->connection->close();

            return true;
        } catch (\Exception $exception) {
            echo 'Exception: ' . $exception->getMessage();
            return false;
        }
    }
}