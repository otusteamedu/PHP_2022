<?php

/*************** General **********************/

echo '<pre>';
echo 'Hello OTUS community!' . PHP_EOL . PHP_EOL;
echo sprintf('Installed version of the PHP: %s' . PHP_EOL . PHP_EOL, phpversion());

/*************** Memcached **********************/

try {
    $memcached = new Memcached();
    $memcached->addServer('memcached', 11211);
    $version = $memcached->getVersion();
    $version = reset($version);

    echo sprintf('Installed version of the Memcached: %s' . PHP_EOL . PHP_EOL, $version);;
} catch (Exception $exception) {
    echo sprintf(
        'Error. The Memcached has not been started with message: %s' . PHP_EOL . PHP_EOL,
        $exception->getMessage()
    );
}

/*************** Redis **********************/

try {
    $redis = new Redis();
    $redis->connect('redis', 6379);

    echo sprintf('Installed version of the Redis: %s'  . PHP_EOL . PHP_EOL, $redis->info()['redis_version']);
} catch (Exception $exception) {
    echo sprintf(
        'Error. Redis has not been started with message: %s'  . PHP_EOL . PHP_EOL,
        $exception->getMessage()
    );
}

/*************** MySQL **********************/

try {
    $dbname   = $_ENV['MYSQL_DATABASE'];
    $password = $_ENV['MYSQL_ROOT_PASSWORD'];

    $mysql = new PDO("mysql:host=mysql;dbname={$dbname}", 'root', $password);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo sprintf(
        'Installed version of the MySQL: %s' . PHP_EOL . PHP_EOL,
        $mysql->getAttribute(PDO::ATTR_SERVER_VERSION)
    );
} catch(PDOException $exception) {
    echo sprintf('Error. MySQL has not been started with message: %s', $exception->getMessage());
}
