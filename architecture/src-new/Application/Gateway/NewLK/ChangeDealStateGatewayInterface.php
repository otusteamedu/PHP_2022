<?php

namespace App\Application\Gateway\NewLK;

use new\Domain\Enum\NewLK\DealState;
use Ramsey\Uuid\UuidInterface;

interface ChangeDealStateGatewayInterface
{
    public function changeDealState(string $appUuid, UuidInterface $bankUuid, DealState $state, string $comment = ''): void;
}