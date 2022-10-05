<?php

declare(strict_types=1);

namespace App\Application\Service;

use Exception;
use Memcached;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use RuntimeException;

class CreditRequestProcessor
{
    private const QUEUE_NAME = 'credit_requests';

    private const MEMCACHED_REQUEST_STATUS = 'READY';
    private const MEMCACHED_REQUEST_TTL = 60 * 60 * 24;

    public function __construct(
        private readonly AMQPStreamConnection $amqpConnection,
        private readonly Memcached $memcached
    ) {
    }

    /**
     * @throws Exception
     */
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

        $this->updateMemcached($data);
        $this->sendMail($data['email_callback']);
    }

    private function updateMemcached(array $data): void
    {
        $requestID = hash('sha256', $data['passport_number']." ".$data['email_callback']);

        $this->memcached->set($requestID, self::MEMCACHED_REQUEST_STATUS, self::MEMCACHED_REQUEST_TTL);

        echo "Request status updated\n\n";
    }

    private function sendMail(string $address): void
    {
        $result = mail($address, 'Credit Approved!', 'Your credit request was approved successfully');

        if ($result) {
            echo "Mail to user was sent\n\n";
        } else {
            echo "Mail wasn't accepted for delivery\n\n";

            throw new RuntimeException("Something is wrong with the mail server!");
        }
    }
}