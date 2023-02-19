<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\Converter\Factory;

use App\Bank\Otkritie\DTO\EnterApplication\Agreement;
use App\Bank\Otkritie\DTO\EnterApplication\AgreementList;
use App\Bank\Otkritie\DTO\EnterApplication\CreditAmount;
use App\Bank\Otkritie\DTO\EnterApplication\InitialFee;
use App\Bank\Otkritie\DTO\EnterApplication\ParticipantList;
use App\Bank\Otkritie\DTO\EnterApplication\PledgeObject;
use App\Bank\Otkritie\DTO\EnterApplication\PledgeObjectList;
use Dvizh\BankBusDTO\NewBusInsuranceTerms;
use Dvizh\BankBusDTO\NewBusLoanData;
use Dvizh\BankBusDTO\NewBusLoanPurpose;

class AgreementListFactory
{
    public static function createByNewBusLoanDataAndParticipantList(
        NewBusLoanData $loan,
        ParticipantList $participantList
    ): AgreementList {
        $agreements = [];

        $agreement = new Agreement(Agreement::TYPE_MORTGAGE);
        $agreement->ParticipantList = $participantList;
        $agreement->CreditAmount = new CreditAmount($loan->amount);
        $agreement->CreditTerm = $loan->period;
        $agreement->InitialFee = new InitialFee($loan->downPaymentAmount);

        $pledgeObject = new PledgeObject($loan->propertyPrice);
        $pledgeObjectList = new PledgeObjectList([$pledgeObject]);
        $agreement->PledgeObjectList = $pledgeObjectList;
        $agreement->EstimatedDuration = $loan->period;

        $agreements[] = $agreement;

        // Полный пакет страхования - это и страхование здоровья, и страхование титула, но для новостройки
        // страхование титула, как правило, не нужно, т.к. это первый собственник
        // note: в данный момент не отправляем, т.к нет логики для подсчета надбавки $AgreementPerscent;
//        if ($loan->insuranceTerms->value === NewBusInsuranceTerms::FULL_PACKAGE) {
//            $healthInsuranceAgreement = new Agreement(Agreement::TYPE_INSURANCE);
//            $healthInsuranceAgreement->InsuranceType = Agreement::INSURANCE_TYPE_LIFE;
//            $agreements[] = $healthInsuranceAgreement;
//
//            if (
//                in_array(
//                    $loan->purpose->value,
//                    [NewBusLoanPurpose::SECONDARY_HOUSING, NewBusLoanPurpose::REFINANCE]
//                )
//            ) {
//                $titleInsuranceAgreement = new Agreement(Agreement::INSURANCE_TYPE_TITLE);
//                $titleInsuranceAgreement->InsuranceType = Agreement::INSURANCE_TYPE_TITLE;
//                $agreements[] = $titleInsuranceAgreement;
//            }
//        }

        return new AgreementList($agreements);
    }
}
