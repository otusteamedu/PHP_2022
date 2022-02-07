<?php
declare(strict_types = 1);
error_reporting(E_ALL & ~E_NOTICE);

$lineBreak = '<br>';
$stringForCheck = 'Привет, Otus!' . $lineBreak . date("Y-m-d H:i:s") . $lineBreak;

print_r( $stringForCheck );

try {
    // Redis
    $redis = new Redis();

    if (
        ! $redis->connect('redis')
        || ! $redis->auth('cf62bf4c11c2dabe92f4114ec522051d')
        || ! $redis->set('Otus', $stringForCheck)
        || empty($redis->get('Otus'))
    ) {
        throw new RuntimeException( $redis->getLastError() );
    }

    $redis->del('Otus');

    print_r( "Redis ready" . $lineBreak );
} catch (Exception $exception) {
    print_r( "Redis error: " . $exception->getMessage() . $lineBreak );
}

try {
    // Memcached
    $memcached = new Memcached;

    if (
        ! $memcached->addServer('memcached', 11211)
        || ! $memcached->set('Otus', $stringForCheck)
        || empty($memcached->get('Otus'))
    ) {
        throw new RuntimeException( $memcached->getLastErrorMessage() );
    }

    $memcached->delete('Otus');
    print_r( "Memcached ready" . $lineBreak);

} catch (Exception $exception) {
    print_r( "Memcached error: " . $exception->getMessage() . $lineBreak );
}