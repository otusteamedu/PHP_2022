<?php
$redis = new \Redis();
$redis->connect(
    'redis',
    6379
);
$redis->auth($_ENV['REDIS_PASSWORD']);
$redis->publish(
    'abc',
    json_encode([
        'test' => 'success'
    ])
);
$redis->close();
