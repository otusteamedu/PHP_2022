<?php

declare(strict_types=1);

include __DIR__ . '/vendor/autoload.php';

echo 'hello';
$client = new Predis\Client(['host' => 'redis_otus']);
if ($client->ping()) {
    echo 'ok';
}
