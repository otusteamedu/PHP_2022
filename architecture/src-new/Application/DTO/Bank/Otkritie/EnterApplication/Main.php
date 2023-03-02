<?php

declare(strict_types=1);

namespace App\Application\DTO\Bank\Otkritie\EnterApplication;

/**
 * Самый верхний элемент в заявке в банк. Содержит в себе всю информацию, которую отправляем в "Открытие" по сделке.
 */
class Main
{
    public OpenAPI $OpenAPI;

    public function __construct(OpenAPI $OpenAPI)
    {
        $this->OpenAPI = $OpenAPI;
    }
}
