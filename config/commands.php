<?php

// Здесь храним список команд. Ключи - название, используемое в консоле, значения - имена классов
return [
    'order:make' => \App\Infrastructure\Command\BurgerQueen\MakeOrder::class,
];