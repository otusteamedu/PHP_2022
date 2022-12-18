<?php
declare(strict_types=1);

namespace Otus\App\Application\Controllers;

use Otus\App\Domain\ProductInterface;
use Otus\App\Application\Observer\ObservableInterface;
use Otus\App\Application\Observer\ObserverInterface;

class Product implements ObservableInterface
{
    //Для паттерна Наблюдатель
    private array $observers;
    private $status = 0;
    const READY_STATUS = 1;

    public function __construct()
    {
        $this->observers = array();
    }
    public function getStatus()
    {
        return $this->status;
    }
    //attach detach notify для паттерна Наблюдатель
    public function attach(ObserverInterface $observer): Product
    {
        $this->observers[] = $observer;
        return $this;
    }

    public function detach(ObserverInterface $observer): Product
    {
        foreach ($this->observers as &$search) {
            if($search == $observer) {
                unset($search);
            }
        }
        return $this;
    }

    public function notify(): Product
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
        return $this;
    }

    public function changeReadyStatus(int $status): Product
    {
        $this->status = $status;
        $this->notify();
        return $this;
    }
}