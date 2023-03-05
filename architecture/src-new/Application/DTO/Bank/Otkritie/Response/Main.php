<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\Response;

/**
 * Самый верхний элемент в ответе банка на запрос с заявкой.
 */
class Main
{
    public OpenAPI $OpenAPI;

    public function __construct(OpenAPI $OpenAPI)
    {
        $this->OpenAPI = $OpenAPI;
    }
}
