<?php

namespace App\NewLK\Messenger\Handler;

use App\Entity\Bank;
use App\NewLK\Client\ChangeDealStateClient;
use App\NewLK\Messenger\Message\ChangeDealStateMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Отправляет запрос в NewLK на изменение статуса сделки
 */
class ChangeDealStateHandler implements MessageHandlerInterface
{
    private ChangeDealStateClient $changeDealStateClient;

    public function __construct(ChangeDealStateClient $changeDealStateClient)
    {
        $this->changeDealStateClient = $changeDealStateClient;
    }

    public function __invoke(ChangeDealStateMessage $message): void
    {
        $this->changeDealStateClient->changeDealState(
            $message->getApplicationId(),
            $message->getBankUuid(),
            $message->getState(),
            $message->getComment() ?? ''
        );
    }
}
