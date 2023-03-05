<?php

declare(strict_types=1);

namespace App\Application\Factory\Bank\Otkritie;

use Dvizh\BankBusDTO\NewBusInsuranceTerms;
use Dvizh\BankBusDTO\NewBusLoanData;
use Dvizh\BankBusDTO\NewBusLoanPurpose;
use App\Application\DTO\Bank\Otkritie\EnterApplication\Agreement;
use App\Application\DTO\Bank\Otkritie\EnterApplication\AgreementList;
use App\Application\DTO\Bank\Otkritie\EnterApplication\CreditAmount;
use App\Application\DTO\Bank\Otkritie\EnterApplication\InitialFee;
use App\Application\DTO\Bank\Otkritie\EnterApplication\ParticipantList;
use App\Application\DTO\Bank\Otkritie\EnterApplication\PledgeObject;
use App\Application\DTO\Bank\Otkritie\EnterApplication\PledgeObjectList;

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

        return new AgreementList($agreements);
    }
}
