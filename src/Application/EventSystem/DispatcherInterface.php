<?php

namespace App\Application\EventSystem;

interface DispatcherInterface
{
    public function dispatch(EventInterface $event): void;
}