<?php

declare(strict_types=1);

namespace App\Service;

use App\EventListener\LogEvent;
use App\Service\Data\Logic;
use RuntimeException;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * RedisService
 */
class RedisService
{
    private ?\Symfony\Component\HttpFoundation\Request $request;
    private LogEvent $logger;

    public function __construct(LogEvent $logger, RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();

        $this->logger = $logger;
    }

    /**
     * @throws \JsonException
     *
     * example:
     */
    public function addEvent(): void
    {
        if (!$this->request->get('id') && !$this->request->get('value')) {
            throw new RuntimeException('Отсутстуют обязательные параметры');
        }

        $logic = new Logic($this->logger);
        $logic->execute();
    }
}