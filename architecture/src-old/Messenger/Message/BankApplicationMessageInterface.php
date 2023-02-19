<?php

namespace App\Messenger\Message;

use Dvizh\BankBusDTO\DeliveryFullQuestionnaire;

/**
 * Заявка, подготовленная для отправки в банк.
 */
interface BankApplicationMessageInterface
{
    public function __construct(DeliveryFullQuestionnaire $questionnaire);

    public function getQuestionnaire(): DeliveryFullQuestionnaire;
}
