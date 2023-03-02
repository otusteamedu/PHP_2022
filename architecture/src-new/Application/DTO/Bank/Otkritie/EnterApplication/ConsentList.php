<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication;

class ConsentList
{
    // возможные ConsentType для объектов Consent, хранящихся в поле Consent
    /** Согласие клиента на ОПС  */
    public const CONSENT_TYPE_OPS_AGREEMENT = 'OPS';
    /** Согласие на запрос в БКИ  */
    public const CONSENT_TYPE_BKI_REQUEST_AGREEMENT = 'BKI';
    /** Согласие на передачу в БКИ  */
    public const CONSENT_TYPE_BKI_TRANSFER_AGREEMENT = 'HISTORY';
    /**
     * @var Consent[]
     */
    public array $Consent;

    /**
     * @param Consent[] $Consent
     */
    public function __construct(array $Consent)
    {
        $this->Consent = $Consent;
    }
}
