<?php
declare(strict_types=1);

namespace Otus\App\Application\Controllers;

use Otus\App\Domain\ProductInterface;
use SplSubject;
use SplObserver;
use SplObjectStorage;

class Product implements SplSubject
{
    //Для паттерна НАБЛЮДАТЕЛЬ
    protected SplObjectStorage $observers;
    private $status = 0;
    const READY_STATUS = 1;

    //Помещаем создание НАБЛЮДАТЕЛЯ прямо в конструктор, чтобы не забыть его создавать для класса PRODUCT (для DI)
    //В данном случае сюда прилетает ObserverMailer
    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }
    public function getStatus()
    {
        return $this->status;
    }
    //attach detach notify для паттерна Наблюдатель
    public function attach(SplObserver $observer): Product
    {
        $this->observers[] = $observer;
        return $this;
    }

    public function detach(SplObserver $observer): Product
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