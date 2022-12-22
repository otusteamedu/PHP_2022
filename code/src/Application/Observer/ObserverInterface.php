<?php

namespace Otus\App\Application\Observer;

interface ObserverInterface
{
    public function update(ObservableInterface $object);
}