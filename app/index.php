<?php

// Memcached
$memcacheD = new Memcached;
$memcacheD->addServer(getenv('MEMCACHED_HOST'), getenv('MEMCACHED_PORT'));
$memcacheD->set('random_num', rand());
echo sprintf('Memcached: %d', $memcacheD->get('random_num'));
echo '<br />';

//Connecting to Redis server on localhost
$redis = new Redis();
$redis->connect(getenv('REDIS_HOST'), getenv('REDIS_PORT'));
$redis->set('random_num', rand());
echo sprintf('Redis: %d', $redis->get('random_num'));
echo '<br />';

try {
    $dbh = new PDO(
        sprintf('%s:host=%s;dbname=%s', getenv('DB_CONNECTION'), getenv('DB_HOST'), getenv('DB_DATABASE')),
        getenv('DB_USERNAME'),
        getenv('DB_PASSWORD')
    );
    foreach ($dbh->query('SELECT NOW()') as $row) {
        print_r($row);
    }
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}


//phpinfo();