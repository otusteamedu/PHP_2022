<?php

declare(strict_types=1);

namespace App\Application\Messenger\Bank\Otkritie\Message;

use Dvizh\BankBusDTO\DeliveryFullQuestionnaire;
use App\Application\Messenger\Common\Message\BankApplicationMessageInterface;

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
