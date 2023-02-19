<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\Response;

/**
 * Информация о заявке.
 */
class Application
{
    /**
     * Идентификаторы.
     */
    public IdList $IdList;

    public AgreementList $AgreementList;

    public function __construct(
        IdList $IdList,
        AgreementList $AgreementList
    ) {
        $this->IdList = $IdList;
        $this->AgreementList = $AgreementList;
    }
}
