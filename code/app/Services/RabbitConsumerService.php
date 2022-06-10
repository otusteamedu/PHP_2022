<?php


namespace App\Services;


use App\Mail\ReportCreatedEmail;
use ErrorException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PhpAmqpLib\Message\AMQPMessage;

final class RabbitConsumerService extends AbstractRabbitService
{
    private const CONSUMER_TAG = 'consumer';

    /**
     * @throws ErrorException
     */
    public function handle(): void
    {
        $this->channel->queue_bind(self::QUEUE, self::EXCHANGE);

        $this->channel->basic_consume(
            self::QUEUE,
            self::CONSUMER_TAG,
            false,
            false,
            false,
            false,
            function (AMQPMessage $message) {
                dump($message->body);

                Log::info($message->body);

                $json = json_decode($message->body, true);

                Mail::to([env('MAIL_FROM_ADDRESS')])->send(new ReportCreatedEmail($json['reportId']));

                $message->ack();
            }
        );

        $this->channel->consume();
    }
}
