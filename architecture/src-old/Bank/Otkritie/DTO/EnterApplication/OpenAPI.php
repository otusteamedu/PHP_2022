<?php

declare(strict_types=1);

namespace App\Bank\Otkritie\DTO\EnterApplication;

use App\Bank\Otkritie\DTO\SystemCode;

class OpenAPI
{
    /**
     * Идентификатор запроса в банк.
     */
    public string $RqID;
    /**
     * Дата и время отправки запроса
     */
    public \DateTimeImmutable $RequestDT;
    /**
     * Код нашей системы в системе банка.
     */
    public SystemCode $SrcSystemCode;
    /**
     * Идентификатор принимающей системы.
     */
    public SystemCode $DstSystemCode;
    /**
     * URL нашего сервиса для приема асинхронного ответа от банка по изменению статуса/параметров одобрения вашей
     * заявки.
     */
    public string $CallbackURL;
    /**
     * Объект заявки.
     */
    public Application $Application;

    public function __construct(Application $Application)
    {
        $this->Application = $Application;
    }
}
