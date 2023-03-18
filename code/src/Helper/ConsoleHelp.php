<?php

namespace Svatel\Code\Helper;

class ConsoleHelp
{
    public static function commands(): string
    {
        return 'Доступные команды:'.PHP_EOL
            .'1. index - Индексирование.'.PHP_EOL
            .'2. search - Поиск, вторым аргументов введите json строку. Без аргумента будет осуществлен дефолтный поиск.'
            .'3. help - Вывести список доступных команд';
    }

    public static function generateResult(array $result): void
    {
        if (empty($result)) {
            print_r('Нет совпадений');
        } else {
            $mask = "|%-30.30s | %-30.30s %-30.30s | %-30.30s | %-30.30s | %-30.30s |\n";
            printf($mask, 'Id', 'Title', 'Sku', 'Category', 'Price');
            foreach ($result as $item) {
                printf($mask, 'Id', 'Title', 'Sku', 'Category', 'Price');
                printf($mask, $item['_id'], $item['_source']['title'], $item['_source']['sku'], $item['_source']['category'], $item['_source']['price']);
            }
        }
    }
}