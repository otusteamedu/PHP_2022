<?php

declare(strict_types=1);

namespace App\Service;

class Logic
{
    public ILogic $object;

    public function __construct(LogicRedis $logicRedis, LogicDb $logicDb)
    {
        if (($_ENV['ENABLE_REDIS'])) {
            $this->object = $logicRedis;
        }  else {
            $this->object = $logicDb;
        }
    }

    /**
     * @throws \JsonException
     */
    public function execute(): void
    {
        $this->object->logic();
    }
}