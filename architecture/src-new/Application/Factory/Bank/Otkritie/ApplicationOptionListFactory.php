<?php

declare(strict_types=1);

namespace App\Application\Factory\Bank\Otkritie;

use Dvizh\BankBusDTO\DeliveryFullQuestionnaire;
use App\Application\DTO\Bank\Otkritie\Option;
use App\Application\DTO\Bank\Otkritie\OptionList;
use App\Application\DTO\Bank\Otkritie\OptionName;

class ApplicationOptionListFactory
{
    public static function createByQuestionnaire(DeliveryFullQuestionnaire $questionnaire): OptionList
    {
        $options = [];

        if (!is_null($questionnaire->borrowerQuestionnaire->loan->propertyRegionCode)) {
            $options[] = new Option(
                OptionName::PRODUCT_REGION,
                $questionnaire->borrowerQuestionnaire->loan->propertyRegionCode
            );
        }

        $options[] = new Option(OptionName::PARTNER_ID, $questionnaire->housingComplex->apiData);
        $options[] = new Option(OptionName::PARTNER_NAME, $questionnaire->manager->fullName->toString());
        $options[] = new Option(OptionName::PARTNER_EMAIL, $questionnaire->manager->contacts->emailAddress ?? '');

        return new OptionList($options);
    }
}
