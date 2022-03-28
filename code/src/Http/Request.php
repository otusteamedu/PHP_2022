<?php

declare(strict_types=1);

namespace Ekaterina\Hw4\Http;

class Request
{
    /**
     * @var array|null поля запроса
     */
    public ?array $fields = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        if (!empty($_POST) && is_array($_POST)) {
            $this->clearData($_POST);
        }
    }

    /**
     * Очистка данных в упрощенном виде (без учета многомерного массива)
     *
     * @param array $arData
     * @return void
     */
    private function clearData(array $arData): void
    {
        foreach ($arData as $key => $value) {
            if (!is_array($value)) {
                $this->fields[$key] = htmlspecialchars(trim($value));
            }
        }
    }
}
