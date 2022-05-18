<?php

namespace App\Service\Data;

use App\EventListener\LogEvent;
use App\Service\MessageGenerator;
use Symfony\Component\EventDispatcher\EventDispatcher;


trait LogicTrait
{
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
            $this->getDispatcher()->addListener(LogEvent::NAME, [$this->logger, 'onLogAction'], $settings->priority);
            $this->getDispatcher()->dispatch($this->logger, LogEvent::NAME);
        }
    }

    public function getDispatcher(): EventDispatcher
    {
        return new EventDispatcher();
    }
}