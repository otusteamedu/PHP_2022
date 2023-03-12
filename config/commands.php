<?php

// Здесь храним список команд. Ключи - название, используемое в консоле, значения - имена классов
return [
    'queue:consume' => \App\Infrastructure\Command\Queue\RabbitQueueConsumeCommand::class,
];