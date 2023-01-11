<?php

namespace Study\Cinema\Infrastructure\Service\EventManager;

use Study\Cinema\Domain\Interface\EventListener;

class EventManager
{
    private array $subscribers = [];

    public function __construct()
    {
        
    }

    public function subscribe(string $eventType, EventListener $listener)
    {
        array_push($this->subscribers, array('eventType'=>$eventType, 'subscriber' =>$listener));

    }

    public function unsubscribe(string $eventType, EventListener $listener)
    {
        foreach ($this->subscribers as $key => $subscriber) {
            if($subscriber['eventType'] == $eventType and $subscriber['subscriber'] == $listener) {
                 unset($this->subscribers[$key]);
            }
        }

    }

    public function notify(string $eventType, string $data)
    {
        foreach ($this->subscribers as $subscriber){

            if($subscriber['eventType'] == $eventType)
                $subscriber['subscriber']->update($data);
        }
    }

}