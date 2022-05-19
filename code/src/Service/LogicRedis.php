<?php

declare(strict_types=1);

namespace App\Service;

use App\EventListener\LogEvent;
use App\Repository\RedisRepository;
use RuntimeException;

/**
 * LogicRedis
 */
class LogicRedis implements ILogic
{
    use LogicTrait;

    /**
     * @var RedisRepository
     */
    public RedisRepository $object;

    /**
     * @var
     */
    private LogEvent $logEvent;

    /**
     * __construct
     */
    public function __construct(LogEvent $logEvent)
    {
        $this->logEvent = $logEvent;
        $this->object = new RedisRepository();
    }

    /**
     * @return void
     */
    public function logic(): void
    {
        $keys = $this->object->getAll();

        if (!$keys) {
            throw new RuntimeException('В массиве нет данных');
        }

        foreach ($keys as $key) {
            $json = $this->object->get($key);
            $this->extracted($json);
        }
    }
}