<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class CreditRequest implements CreditRequestInterface
{
    private const QUEUE_NAME = 'credit_requests';

    public function __construct(
        private readonly string $name,
        private readonly string $passport_number,
        private readonly string $passport_who,
        private readonly string $passport_when,
        private readonly string $email_callback,
        private readonly AMQPStreamConnection $amqpConnection
    ) {
    }

    public function send(): void
    {
        $amqpChannel = $this->amqpConnection->channel();

        $amqpChannel->queue_declare(self::QUEUE_NAME, false, false, false, false);

        $data = json_encode([
            'name' => $this->name,
            'passport_number' => $this->passport_number,
            'passport_who' => $this->passport_who,
            'passport_when' => $this->passport_when,
            'email_callback' => $this->email_callback,
        ]);

        $msg = new AMQPMessage($data);
        $amqpChannel->basic_publish($msg, '', self::QUEUE_NAME);

        $amqpChannel->close();
        $this->amqpConnection->close();
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