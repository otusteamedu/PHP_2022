<?php

declare(strict_types=1);

namespace App\Infrastructure\Command;

class BookShopSearchingCommand implements CommandInterface
{
    public static function getDescription(): string
    {
        return 'Осуществляет поиск в магазине по заданным параметрам';
    }
    public function execute(): void
    {

    }
}