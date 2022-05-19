<?php

declare(strict_types=1);

namespace App\Service;

use RuntimeException;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * RedisService
 */
class RedisService
{
    private ?\Symfony\Component\HttpFoundation\Request $request;
    private Logic $logic;

    public function __construct(RequestStack $requestStack, Logic $logic)
    {
        $this->logic = $logic;
        $this->request = $requestStack->getCurrentRequest();
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

        $this->logic->execute();
    }
}