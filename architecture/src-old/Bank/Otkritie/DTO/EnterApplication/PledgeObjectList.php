<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

/**
 * Стоимость объекта недвижимости.
 */
class PledgeObjectList
{
    /**
     * @var PledgeObject[]
     */
    public array $PledgeObject;

    /**
     * @param PledgeObject[] $PledgeObject
     */
    public function __construct(array $PledgeObject)
    {
        $this->PledgeObject = $PledgeObject;
    }
}
