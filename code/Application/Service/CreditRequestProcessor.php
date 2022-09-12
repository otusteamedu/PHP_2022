<?php

declare(strict_types=1);

namespace App\Application\Service;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use RuntimeException;

class CreditRequestProcessor
{
    private const QUEUE_NAME = 'credit_requests';

    public function __construct(private readonly AMQPStreamConnection $amqpConnection)
    {
    }

    public function listen(): void
    {
        $amqpChannel = $this->amqpConnection->channel();

        $amqpChannel->queue_declare(self::QUEUE_NAME, false, false, false, false);

        $amqpChannel->basic_consume(
            self::QUEUE_NAME, '', false, true, false, false,
            [$this, 'processCreditRequest']
        );

        while (count($amqpChannel->callbacks)) {
            $amqpChannel->wait();
        }

        $amqpChannel->close();
        $this->amqpConnection->close();
    }

    public function processCreditRequest(AMQPMessage $msg): void
    {
        $data = json_decode($msg->body, true);

        echo "Credit request data: ".implode('; ', $data)."\n";

        $result = mail($data['email_callback'], 'Credit Approved!', 'Your credit request was approved successfully');

        if ($result) {
            echo "Mail to user was sent\n\n";
        } else {
            echo "Mail wasn't accepted for delivery\n\n";

            throw new RuntimeException("Something is wrong with the mail server!");
        }
    }
}