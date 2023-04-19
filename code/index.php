<?php

declare(strict_types=1);

include __DIR__ . '/vendor/autoload.php';

try {
    \Svatel\Code\Infrastructure\Gateway\IndexGateway::run();
} catch (Exception $e) {
    print_r($e->getMessage());
}
