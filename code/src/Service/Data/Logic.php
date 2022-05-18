<?php

declare(strict_types=1);

namespace App\Service\Data;

class Logic
{
    public ILogic $object;

    public function __construct($logger)
    {
        if ($_ENV['ENABLE_REDIS']) {
            $this->object = new LogicRedis($logger);
        }  else {
            $this->object = new LogicDb($logger);
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