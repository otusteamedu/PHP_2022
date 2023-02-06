<?php

namespace Study\Cinema\Infrastructure\Service\Statement;

use Study\Cinema\Infrastructure\Service\Queue\StatementConsumer\StatementReceivedDTO;
use Study\Cinema\Infrastructure\Service\Queue\EmailPublisher\EmailPublisher;

class StatementService
{

    public function __construct()
    {
    }

    public function createStatement(StatementReceivedDTO $dto, EmailPublisher $emailPublisher)
    {
        //сходить в базу собрать данные
        //отправить письмо с итогом
        $emailPublisher->send(['from' => 'config.email', 'title'=> 'letter_title', 'to' => $dto->getEmail(), 'body' => [1, 2, 3, 4] ]);
        return json_encode(['data'=>['startDate' => $dto->getDateFrom(), 'dateTill'=> $dto->getDateTill(), 'email' => $dto->getEmail(), 'rows' => [1, 2, 3, 4] ]]);
    }


}