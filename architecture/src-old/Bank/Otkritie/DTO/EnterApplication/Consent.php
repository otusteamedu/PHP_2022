<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

/**
 * Согласие клиента на ОПС, запрос в БКИ, передачу в БКИ.
 */
class Consent
{
    public string $ConsentType;

    public BoolStringValue $Value;

    /**
     * Дата согласия БКИ (только для type=БКИ)
     * Формат: 2021-12-15.
     */
    public string $AquireDate;

    public function __construct(string $ConsentType, BoolStringValue $Value)
    {
        $this->ConsentType = $ConsentType;
        $this->Value = $Value;
    }
}
