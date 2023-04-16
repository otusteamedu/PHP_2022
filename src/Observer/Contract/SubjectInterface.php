<?php

namespace Otus\Task14\Observer\Contract;

interface SubjectInterface
{
    public function registerObserver(ObserverInterface $observer);
    public function removeObserver(ObserverInterface $observer);

}