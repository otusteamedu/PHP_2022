<?php

declare(strict_types=1);

namespace Eliasjump\HwRedis\Controllers;

class MainPageController extends BaseController
{
    public function run(): string
    {
        $text = [];
        $text[] = "Привет. Это домашняя работа по Redis из курса PHP 2022 Professional<br/>";
        $text[] = "Для работы используйте следующие post-запросы: <br/>";
        $text[] = "<ul>";
        $text[] = "<li><b>events/create</b> - добавить событие</li>";
        $text[] = "<li><b>events/truncate</b> - очистить все события</li>";
        $text[] = "<li><b>events/show</b> - получить событие по условию</li>";
        $text[] = "</ul>";
        return implode("", $text);
    }
}