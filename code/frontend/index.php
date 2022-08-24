<?php
require_once __DIR__ . '/../backend/vendor/autoload.php';

use Socket\SocketChat;

try {
    $chat = new SocketChat(true);
} catch (Throwable $e) {
    echo $e->getMessage();
}

