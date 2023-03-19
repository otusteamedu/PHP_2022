<?php

namespace Svatel\Code\Helper;

class ConsoleHelp
{
    public static function commands(): string
    {
        return
            'Доступные команды:' . PHP_EOL
            . '1. create arg1 arg2 arg3 - Индексирование' . PHP_EOL
            . 'agr1 - Название индекса'
            . 'agr2 - Путь для файла индеса'
            . 'agr3 - Путь до файла маппинга'
            . '2. search arg1 - Поиск, вторым аргументов введите json строку или путь до файла'
            . '3. help - Вывести список доступных команд';
    }

    public static function generateResult(array $result): void
    {
        if (empty($result)) {
            print_r('Нет совпадений');
        } else {
            $mask = "";
            for ($i = 0; $i < count($result); $i++) {
                $mask .= "|%-30.30s";
                if (count($result) - $i == 1) {
                    $mask .= "|\n";
                }
            }
            foreach ($result as $item) {
                printf($mask, array_keys($item));
                printf($mask, array_values($item));
            }
        }
    }
}
