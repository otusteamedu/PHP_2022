<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\Converter\Factory;

use App\Bank\Otkritie\DTO\Option;
use App\Bank\Otkritie\DTO\OptionList;
use App\Bank\Otkritie\DTO\OptionName;
use Dvizh\BankBusDTO\DeliveryFullQuestionnaire;

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
