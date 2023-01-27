<?php

namespace App\Services\QueueServices;

use App\Mail\ReportCreatedEmail;
use App\Services\Interfaces\ConsumerQueueInterface;
use App\Services\Interfaces\ReportExecuteHandlerInterface;
use App\Services\QueueService;
use ErrorException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PhpAmqpLib\Message\AMQPMessage;
use Throwable;

final class RabbitConsumerQueueService extends AbstractRabbitService implements ConsumerQueueInterface
{
    private const CONSUMER_TAG = 'consumer';

    /**
     * @throws ErrorException
     */
    public function handle(ReportExecuteHandlerInterface $handler): void
    {
        $this->channel->queue_bind(self::QUEUE, self::EXCHANGE);

        $this->channel->basic_consume(
            self::QUEUE,
            self::CONSUMER_TAG,
            false,
            false,
            false,
            false,
            function (AMQPMessage $message) use ($handler) {
                Log::info($message->body);

                $json = json_decode($message->body, true, 512, JSON_THROW_ON_ERROR);

                $id = (int)$json['reportId'];

                try {
                    $handler->setStatusQueue($id, QueueService::STATUS_PROCESS);

                    sleep(10);

                    $handler->process($id);

                    Mail::to([env('MAIL_FROM_ADDRESS')])->send(new ReportCreatedEmail($id));

                    $handler->setStatusQueue($id, QueueService::STATUS_DONE);

                    $message->ack();
                } catch (Throwable $exception) {
                    Log::warning($exception->getMessage());
                    $handler->setStatusQueue($id, QueueService::STATUS_ERROR);
                } finally {
                    Log::info('End work with report');
                }
            }
        );

        $this->channel->consume();
    }
}
