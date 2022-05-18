<?php

declare(strict_types=1);

namespace App\Service\Data;

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
    private $logger;

    /**
     * __construct
     */
    public function __construct($logger)
    {
        $this->logger = $logger;
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