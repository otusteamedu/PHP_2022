<?php

namespace Otus\App\Application\Observer;

use Otus\App\Application\Observer\ObserverInterface;
use Otus\App\Application\Controllers\Product;

class ObserverMailer implements ObserverInterface
{
    private function send($message) {
        echo __CLASS__ . ' : ' . $message;
    }

    public function update(ObservableInterface $product) {
        if ($product->getStatus() == Product::READY_STATUS) {
            $this->send("Продукт готов\n", Product::READY_STATUS);
        }
    }
}