<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\Response;

use App\Application\DTO\Bank\Otkritie\SystemCode;

class OpenAPI
{
    /**
     * Идентификатор запроса в банк.
     */
    public string $RqID;

    /**
     * Код отправляющей системы в системе банка.
     */
    public SystemCode $SrcSystemCode;

    /**
     * Идентификатор принимающей системы.
     */
    public SystemCode $DstSystemCode;

    public ?\DateTimeImmutable $RequestDT;
    /**
     * Объект заявки.
     */
    public Application $Application;

    public Status $Status;
}
