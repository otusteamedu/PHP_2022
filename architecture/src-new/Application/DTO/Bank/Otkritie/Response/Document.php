<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\Response;

use App\Application\Serialization\ChangingTypeNormalizable;


class Document implements ChangingTypeNormalizable
{
    public IdList $IdList;

    public function __construct(IdList $IdList)
    {
        $this->IdList = $IdList;
    }
}
