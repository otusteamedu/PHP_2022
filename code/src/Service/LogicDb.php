<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\JsonEvent;
use App\EventListener\LogEvent;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;

/**
 * LogicDb
 */
class LogicDb implements ILogic
{
    use LogicTrait;

    /**
     * @var array
     */
    public array $array;
    private LogEvent $logEvent;

    /**
     * __construct
     */
    public function __construct(LogEvent $logEvent, EntityManagerInterface $doctrine)
    {
        $this->logEvent = $logEvent;
        $this->array = $doctrine->getRepository(JsonEvent::class)->findAll();
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function logic() : void
    {
        if (!$this->array) {
            throw new RuntimeException('В объекте нет данных');
        }

        foreach ($this->array as $r) {
            $json = $r->getValue();
            $this->extracted($json);
        }
    }
}