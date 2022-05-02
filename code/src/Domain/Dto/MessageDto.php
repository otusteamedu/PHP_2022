<?php
declare(strict_types=1);


namespace Otus\SocketApp\Domain\Dto;


use Otus\SocketApp\Domain\Interface\MessageDtoInterface;

class MessageDto implements MessageDtoInterface
{
    public function __construct(public string $user, public string $message)
    {
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}