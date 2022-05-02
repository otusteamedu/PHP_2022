<?php


namespace Otus\SocketApp\Domain\Interface;


interface MessageDtoInterface
{
    public function getUser(): string;

    public function getMessage(): string;
}