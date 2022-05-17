<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\JsonEvent;
use App\EventListener\LogEvent;
use App\Repository\RedisRepository;
use Doctrine\Persistence\ManagerRegistry;
use RuntimeException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * RedisService
 */
class RedisService
{
    /**
     * @var EventDispatcher
     */
    private EventDispatcher $dispatcher;
    /**
     * @var LogEvent
     */
    private LogEvent $logEvent;
    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $doctrine;
    private ?\Symfony\Component\HttpFoundation\Request $request;

    /**
     * @param LogEvent $logEvent
     * @param ManagerRegistry $doctrine
     */
    public function __construct(LogEvent $logEvent, ManagerRegistry $doctrine, RequestStack $requestStack)
    {
        $dispatcher = new EventDispatcher();
        $this->request = $requestStack->getCurrentRequest();
        $this->logEvent = $logEvent;
        $this->dispatcher = $dispatcher;
        $this->doctrine = $doctrine;
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

        if ($_ENV['ENABLE_REDIS']) {
            $result = new RedisRepository();
            $this->logicRedis($result);
        }  else {
            $result = $this->doctrine->getRepository(JsonEvent::class)->findAll();
            $this->logicDb($result);
        }
    }

    /**
     * @throws \JsonException
     */
    public function logicRedis($result): void
    {
        $keys = $result->getAll();

        if (!$keys) {
            throw new RuntimeException('В массиве нет данных');
        }

        foreach ($keys as $key) {
            $json = $result->get($key);
            $this->extracted($json);
        }
    }

    public function logicDb($result): void
    {
        if (!$result) {
            throw new RuntimeException('В объекте нет данных');
        }

        foreach ($result as $r) {
            $json = $r->getValue();
            $this->extracted($json);
        }
    }

    /**
     * @param mixed $json
     * @return void
     * @throws \JsonException
     */
    public function extracted(mixed $json): void
    {
        $settings = json_decode($json, null, 512, JSON_THROW_ON_ERROR);
        $conditions = $settings->conditions;

        if (empty($conditions) === false && empty($conditions->id) === false && empty($conditions->title) === false) {
            $this->dispatcher->addListener(LogEvent::NAME, [$this->logEvent, 'onLogAction'], $settings->priority);
            $this->dispatcher->dispatch($this->logEvent, LogEvent::NAME);
        }
    }
}