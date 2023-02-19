<?php

namespace Study\Cinema\Infrastructure\Service\Request;

use Study\Cinema\Infrastructure\Service\Queue\RequestConsumer\RequestReceivedDTO;
use Study\Cinema\Infrastructure\Service\Queue\EmailPublisher\EmailPublisher;

class RequestService
{
    public function createRequest(RequestReceivedDTO $dto, EmailPublisher $emailPublisher): bool
    {
        //сходить в базу собрать данные
         sleep(5);

        //отправить письмо с итогом
        $emailPublisher->send(['from' => 'config.email', 'title'=> 'letter_title', 'to' => $dto->getEmail(), 'body' => [1, 2, 3, 4] ]);
        return true;
    }

}