<?php

namespace App\Application\Messenger\NewLK\Handler;

use App\Application\Messenger\NewLK\Message\ChangeDealStateMessage;
use App\Application\Gateway\NewLK\ChangeDealStateGatewayInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Отправляет запрос в NewLK на изменение статуса сделки
 */
class ChangeDealStateHandler implements MessageHandlerInterface
{
    public function __construct(private readonly ChangeDealStateGatewayInterface $changeDealStateGateway)
    {
    }

    public function __invoke(ChangeDealStateMessage $message): void
    {
        $this->changeDealStateGateway->changeDealState(
            $message->getApplicationId(),
            $message->getBankUuid(),
            $message->getState(),
            $message->getComment() ?? ''
        );
    }
}
