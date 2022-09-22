<?php
declare(strict_types=1);

namespace App\Application\Controllers;

use App\Domain\Contracts\ProductInterface;

class Product implements \SplSubject
{
    public const READY_TO_DELIVER = 10;
    protected \SplObjectStorage $observers;
    protected int $stage;

    public function __construct()
    {
        $this->observers = new \SplObjectStorage();
    }

    public function attach(\SplObserver $observer): Product
    {

        $this->observers->attach($observer);
        return $this;
    }

    public function detach(\SplObserver $observer): Product
    {
        $this->observers->detach($observer);
        return $this;
    }

    public function changePreparingStage(int $stage): Product
    {
        $this->stage = $stage;
        $this->notify();
        return $this;
    }

    public function notify(): Product
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
        return $this;
    }

    public function getStage()
    {
        return $this->stage;
    }


}