<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

use Nikolai\Php\Application\Service\FlushService;

class FlushController implements ControllerInterface
{
    public function __construct(private FlushService $flushService) {}

    public function __invoke($request)
    {
        $flushResponse = $this->flushService->flush();

        fwrite(STDOUT, $flushResponse->massage . PHP_EOL);
    }
}