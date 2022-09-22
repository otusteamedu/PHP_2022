<?php
declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Contracts\SendMessageInterface;
use App\Domain\Contracts\DeliveryServiceInterface;
use SplSubject;
use SplObserver;

class DeliveryService implements DeliveryServiceInterface, \SplObserver
{
    protected SendMessageInterface $textTransport;

    /**
     * @param SendMessageInterface $textTransport
     */
    public function __construct(SendMessageInterface $textTransport)
    {
        $this->textTransport = $textTransport;
    }

    public function deliverOrder()
    {
        $this->textTransport->sendMessage("Product ready to deliver.");
    }

    public function update(SplSubject $subject)
    {
        if ($subject->getStage() == Product::READY_TO_DELIVER)
            $this->deliverOrder();
    }
}