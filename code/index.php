<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

try {
    \Svatel\Code\Gateway\IndexGateway::run();
} catch (Exception $e) {
    print_r($e->getMessage());
}
