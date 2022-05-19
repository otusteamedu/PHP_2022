<?php

namespace App\Service;

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
        $dispatcher = new EventDispatcher();

        if (empty($conditions) === false && empty($conditions->id) === false && empty($conditions->title) === false) {
            $dispatcher->addListener(LogEvent::NAME, [$this->logEvent, 'onLogAction'], $settings->priority);
            $dispatcher->dispatch($this->logEvent, LogEvent::NAME);
        }
    }
}