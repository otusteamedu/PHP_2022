<?php

namespace App\Service;

use Dvizh\BankBusDTO\DeliveryFullQuestionnaire;
use Dvizh\BankBusDTO\NewBusPerson;
use Dvizh\BankBusDTO\NewBusPersonRole;

class QuestionnaireService
{
    public static function getMainBorrower(DeliveryFullQuestionnaire $questionnaire): NewBusPerson
    {
        foreach ($questionnaire->borrowerQuestionnaire->persons as $person) {
            if ($person->role->extract() === NewBusPersonRole::BORROWER) {
                return $person;
            }
        }

        throw new \RuntimeException();
    }
}
