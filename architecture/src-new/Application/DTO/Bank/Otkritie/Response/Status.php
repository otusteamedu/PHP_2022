<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\Response;

class Status
{
    public const STATUS_CODE_SUCCESS = 0;
    public const STATUS_CODE_ERROR = 100;
    /**
     * Код.
     */
    public int|string $StatusCode;

    /**
     * Значение кода.
     */
    public string $Severity;

    /**
     * Сообщение.
     */
    public ?string $Msg;
}
