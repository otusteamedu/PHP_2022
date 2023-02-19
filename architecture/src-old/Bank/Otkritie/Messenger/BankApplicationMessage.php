<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\Messenger;

use App\Messenger\Message\BankApplicationMessageInterface;
use Dvizh\BankBusDTO\DeliveryFullQuestionnaire;

/**
 *  Message для SymfonyMessenger для обработки заявки в банк Открытие.
 */
class BankApplicationMessage implements BankApplicationMessageInterface
{
    private DeliveryFullQuestionnaire $questionnaire;

    public function __construct(DeliveryFullQuestionnaire $questionnaire)
    {
        $this->questionnaire = $questionnaire;
    }

    public function getQuestionnaire(): DeliveryFullQuestionnaire
    {
        return $this->questionnaire;
    }
}
