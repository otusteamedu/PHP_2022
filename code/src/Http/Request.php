<?php

declare(strict_types=1);

namespace Ekaterina\Hw4\Http;

use Exception;

class Request
{
    /**
     * @var array|null поля запроса
     */
    public ?array $fields = null;

    /**
     * Constructor
     *
     * @throws Exception
     */
    public function __construct()
    {
        if (empty($_POST)) {
            throw new Exception('Требуется POST-запрос');
        } else {
            $this->prepareData($_POST);
        }
    }

    /**
     * Подготовка данных для последующей работы с ними в упрощенном виде (без учета многомерного массива)
     *
     * @param array $arData
     * @return void
     */
    private function prepareData(array $arData): void
    {
        foreach ($arData as $key => $value) {
            if (!is_array($value)) {
                $this->fields[$key] = htmlspecialchars(trim($value));
            }
        }
    }
}
