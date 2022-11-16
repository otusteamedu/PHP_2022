<?php

declare(strict_types = 1);

namespace VeraAdzhieva\Hw4;

use VeraAdzhieva\Hw4\Service\Validator;

class Request
{
    /**
     * @param array $params
     *
     * @return void
     */
    public function checkRequest(array $params): void
    {
        $string = (isset($params['string']) ? $params['string'] : '');
        $validator = new Validator();
        $valid = $validator->regexCheck($string);
        $code = ($valid ? 200 : 400);

        switch($code) {
            case 200:
                header ( "Строка корректна!", true, $code);
                break;

            case 400:
                header ( "Ошибка: строка некорректна!", true, $code);
                break;
        }
    }
}