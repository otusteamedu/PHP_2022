<?php

// Здесь храним список команд. Ключи - название, используемое в консоле, значения - имена классов
return [
    'book-shop:search' => \App\Infrastructure\Command\BookShopSearchingCommand::class,
];