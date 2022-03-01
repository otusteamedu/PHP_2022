<?php

declare(strict_types=1);

namespace Philip\Otus\Core\View;

class Greeting
{
    public function __invoke()
    {
        $_SESSION['count'] = ($_SESSION['count'] ?? 0) + 1;
        dump([$_SESSION['count'], "Запрос обработал контейнер: " . $_SERVER['HOSTNAME']]);
    }
}