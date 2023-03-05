<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\Response;

use App\Serializer\ChangingTypeNormalizable;

/**
 * Участник заявки.
 */
class Party implements ChangingTypeNormalizable
{
    public IdList $IdList;

    public ?DocumentList $DocumentList;

    public function __construct(
        IdList $IdList,
        ?DocumentList $DocumentList
    ) {
        $this->IdList = $IdList;
        $this->DocumentList = $DocumentList;
    }
}
