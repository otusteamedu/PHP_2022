<?php

declare(strict_types=1);

namespace App\Application\EventListener;

use App\Application\Entity\CreditRequestProxy;
use App\Domain\Entity\CreditRequest;
use App\Domain\Event\CreditRequested;

class CreditRequestListener
{
    public function __invoke(CreditRequested $event): void
    {
        $requestData = $event->getEventData();

        $request = new CreditRequestProxy(
            new CreditRequest(
                name: $requestData['lastname'].$requestData['firstname'].$requestData['middlename'],
                passport_number: $requestData['passport_number'],
                passport_who: $requestData['passport_who'],
                passport_when: $requestData['passport_when']
            ), $event->getIdentityMap()
        );

        $request->send();
    }
}