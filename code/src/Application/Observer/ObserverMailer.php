<?php

namespace Otus\App\Application\Observer;

use Otus\App\Domain\Model\Controllers\Product;
use SplObserver;
use SplSubject;

class ObserverMailer implements SplObserver
{
    public function update(SplSubject $subject) {
        if ($subject->getStatus() == Product::READY_STATUS) {
            $this->send("Продукт готов\n", Product::READY_STATUS);
        }
    }

    private function send($message) {
        echo __CLASS__ . ' : ' . $message;
    }
}