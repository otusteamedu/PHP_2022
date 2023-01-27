<?php

namespace App\Services\QueueServices;

use App\Services\Dtos\ReportDto;
use App\Services\Interfaces\PublisherQueueInterface;
use JsonException;
use PhpAmqpLib\Message\AMQPMessage;

final class RabbitPublisherQueueService extends AbstractRabbitService implements PublisherQueueInterface
{
    /**
     * @throws JsonException
     */
    public function handle(ReportDto $dto): void
    {
        $this->channel->queue_bind(self::QUEUE, self::EXCHANGE);

        $message = $this->createMassage($dto);
        $this->channel->basic_publish($message, self::EXCHANGE);
    }

    /**
     * @throws JsonException
     */
    private function createMassage(ReportDto $dto): AMQPMessage
    {
        $data = [
            'reportId' => $dto->getReport()->id,
            'params' => $dto->getParams(),
        ];
        $preparedMessage = json_encode($data, JSON_THROW_ON_ERROR);

        return new AMQPMessage(
            $preparedMessage,
            [
                'content_type' => 'text/plain',
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
            ]
        );
    }
}
