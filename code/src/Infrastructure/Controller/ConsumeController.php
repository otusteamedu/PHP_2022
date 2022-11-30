<?php

declare(strict_types=1);

namespace Nikolai\Php\Infrastructure\Controller;

use Nikolai\Php\Infrastructure\Service\ConsumeMessageInterface;
use Symfony\Component\HttpFoundation\Request;

class ConsumeController implements ControllerInterface
{
    public function __construct(private ConsumeMessageInterface $consumeMessageService) {}

    public function __invoke(Request $request)
    {
        $this->consumeMessageService->consume();
    }
}