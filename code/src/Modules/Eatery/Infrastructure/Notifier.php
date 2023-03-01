<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Modules\Eatery\Infrastructure;

use Nikcrazy37\Hw14\Modules\Eatery\Domain\Status\StatusEnum;
use SplSubject;

class Notifier implements \SplObserver
{
    /**
     * @param SplSubject $subject
     * @return void
     */
    public function update(SplSubject $subject): void
    {
        if ($subject->order->getStatus()->getValue() === StatusEnum::COMPLETED) {
            $orderId = $subject->order->getId()->getValue();
            $status = $subject->order->getStatus()->getValue()->value;

            echo "Notification: Order №$orderId $status!<br>";
        }
    }
}