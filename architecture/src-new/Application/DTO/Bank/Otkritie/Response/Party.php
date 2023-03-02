<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\Response;

use App\Application\Serialization\ChangingTypeNormalizable;

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
