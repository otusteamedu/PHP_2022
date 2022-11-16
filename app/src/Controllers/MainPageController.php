<?php

declare(strict_types=1);

namespace Eliasjump\StringsVerification\Controllers;

use function Eliasjump\StringsVerification\Functions\Validates\validateBraces;

class MainPageController extends BaseController
{
    public function run(): string
    {
        $text = [];

        $text[] = 'ID сессии: ' . session_id();
        $text[] = "Счетчик посещений: " . $_SESSION['counter'];
        $text[] = "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];

        return implode("<br/>", $text);
    }
}
