<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Service;

use Nikolai\Php\Application\Contract\EventClientInterface;
use Nikolai\Php\Application\Dto\FlushResponse;

class FlushService
{
    public function __construct(private EventClientInterface $eventClient) {}

    public function flush(): FlushResponse
    {
        return $this->eventClient->flush();
    }
}