<?php

namespace Patterns\Observer;

interface ObservablesInterface
{
    public function addObserver(ObserverInterface $observer): void;

    public function removeObserver(ObserverInterface $observer): void;

    public function notifyObservers(): void;

}
