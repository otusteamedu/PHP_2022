<?php

require_once __DIR__ . '/vendor/autoload.php';

use Src\Engine;

$chat = new Engine(argv: $argv);

try {
    $chat->startChat();
} catch(Throwable $exception) {
    fwrite(
        stream: STDOUT,
        data: 'Error: ' . $exception->getMessage() . PHP_EOL
        . 'Trace: ' . $exception->getTraceAsString() . PHP_EOL
    );
}
