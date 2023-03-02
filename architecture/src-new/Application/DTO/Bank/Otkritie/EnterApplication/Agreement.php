<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication;

class Agreement
{
    public const TYPE_MORTGAGE = 'T_MortgageAgreement';
    public const TYPE_INSURANCE = 'T_InsuranceAgreement';

    /** Страхование жизни и трудоспособности */
    public const INSURANCE_TYPE_LIFE = 'LifeAndDisabilityInsurance';
    /** Страхование титула */
    public const INSURANCE_TYPE_TITLE = 'TitleInsurance';

    public string $typeAgreement;
    /**
     * Участники заявки.
     */
    public ParticipantList $ParticipantList;
    /**
     * Сумма кредита.
     */
    public CreditAmount $CreditAmount;
    /**
     * Срок кредита в месяцах.
     */
    public int $CreditTerm;
    /**
     * Стоимость объекта недвижимости.
     */
    public PledgeObjectList $PledgeObjectList;
    /**
     * Первоначальный взнос
     */
    public InitialFee $InitialFee;
    /**
     * Подтип соглашения
     */
    public string $InsuranceType;
    /**
     * Внутреннее рефинансирование
     */
    public bool $IsExternal;
    /**
     * Срок кредита,мес
     */
    public int $EstimatedDuration;
    /**
     * Надбавка за отсутствие страхования в процентах (только для страхования жизни и титула)
     */
    public float $AgreementPerscent;

    public function __construct(string $typeAgreement)
    {
        $this->typeAgreement = $typeAgreement;
    }
}
