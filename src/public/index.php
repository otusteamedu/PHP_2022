<?php

declare(strict_types=1);

try {
    (new \Redis)->connect('redis');
    echo 'Redis is working';
} catch (Exception $exception) {
    echo 'Error with Redis';
}
echo "<br/>";
try {
    (new \Memcached)->addServer("memcached", 11211);
    echo 'Memcached is working';
} catch (Exception $exception) {
    echo 'Error with Memcached';
}
