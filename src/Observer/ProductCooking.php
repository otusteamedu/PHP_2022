<?php

namespace Otus\Task14\Observer;

use Otus\Task14\Observer\Contract\NotifyInterface;
use Otus\Task14\Observer\Contract\ObserverInterface;
use Otus\Task14\Observer\Contract\SubjectInterface;

class ProductCooking implements SubjectInterface
{
    private array $observer = [];
    public function __construct(
       // private readonly OrderStrategyInterface $order,
    ){
        echo 'Начинаем готовить'. PHP_EOL ;

    }

    public function cooking(): void
    {
        $this->notifyObserver();
    }

    public function notifyObserver()
    {
        foreach ($this->observer as $observer){
            $observer->notify($observer);
        }
    }


    public function registerObserver(ObserverInterface $observer)
    {
        $this->observer[get_class($observer)] = $observer;
    }

    public function removeObserver(ObserverInterface $observer)
    {
        unset($this->observer[get_class($observer)]);
    }


}