<?php

namespace Otus\App\Application\Observer;

interface ObservableInterface
{
    public function attach(ObserverInterface $observer);
    public function detach(ObserverInterface $observer);
    public function notify();
}