<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\Response;

use App\Serializer\ChangingTypeNormalizable;

class Document implements ChangingTypeNormalizable
{
    public IdList $IdList;

    public function __construct(IdList $IdList)
    {
        $this->IdList = $IdList;
    }
}
