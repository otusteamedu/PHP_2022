<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Exception;
use Memcached;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class CreditRequest implements CreditRequestInterface
{
    private const QUEUE_NAME = 'credit_requests';

    private const MEMCACHED_REQUEST_STATUS = 'PROCESSING';
    private const MEMCACHED_REQUEST_TTL = 60 * 60 * 24;

    public function __construct(
        private readonly string $name,
        private readonly string $passport_number,
        private readonly string $passport_who,
        private readonly string $passport_when,
        private readonly string $email_callback,
        private readonly AMQPStreamConnection $amqpConnection,
        private readonly Memcached $mcConnection
    ) {
    }

    /**
     * @throws Exception
     */
    public function send(): void
    {
        $this->sendRabbitMQ();
        $this->sendMemcached();
    }

    /**
     * @throws Exception
     */
    private function sendRabbitMQ(): void
    {
        $amqpChannel = $this->amqpConnection->channel();

        $amqpChannel->queue_declare(self::QUEUE_NAME, false, false, false, false);

        $data = json_encode([
            'name' => $this->name,
            'passport_number' => $this->passport_number,
            'passport_who' => $this->passport_who,
            'passport_when' => $this->passport_when,
            'email_callback' => $this->email_callback,
        ], JSON_THROW_ON_ERROR);

        $msg = new AMQPMessage($data);
        $amqpChannel->basic_publish($msg, '', self::QUEUE_NAME);

        $amqpChannel->close();
        $this->amqpConnection->close();
    }

    private function sendMemcached(): void
    {
        $requestID = hash('sha256', $this->passport_number." ".$this->email_callback);

        $this->mcConnection->set($requestID, self::MEMCACHED_REQUEST_STATUS, self::MEMCACHED_REQUEST_TTL);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassportNumber(): string
    {
        return $this->passport_number;
    }

    public function getPassportWho(): string
    {
        return $this->passport_who;
    }

    public function getPassportWhen(): string
    {
        return $this->passport_when;
    }

    public function getEmailCallback(): string
    {
        return $this->email_callback;
    }
}