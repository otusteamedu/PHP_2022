<?php

namespace Patterns\Observer;

interface ObserverInterface
{
    public function handleEvent(array $vacancies): void;
}
