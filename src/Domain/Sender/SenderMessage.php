<?php

declare(strict_types=1);

namespace DKozlov\Otus\Domain\Sender;

class SenderMessage
{
    public function __construct(
        private string $to,
        private string $subject,
        private string $body
    ) {
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }
}