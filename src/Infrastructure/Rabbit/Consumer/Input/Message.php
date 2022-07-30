<?php

namespace App\Infrastructure\Rabbit\Consumer\Input;

class Message
{
    private string $id;

    public static function createFromQueue(string $messageBody): self
    {
        $message = new self;
        $body = json_decode($messageBody, true);

        $message->id = $body['statementId'];

        return $message;
    }


    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }


}
