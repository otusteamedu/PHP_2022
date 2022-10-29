<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>application.local</title>
</head>
<body>

Good evening, world. Today is <?=date('Y-m-d') ?>.

<?php

try
{
    $redis = new \Redis;
    $redis->connect('redis');
    $redis->set('rediskey', '<br>Сохранено в redis');
    $fromRedis = $redis->get('rediskey');
    echo $fromRedis;
}
catch(\Exception $e)
{
    echo '<br>Redis не работает: '.$e->getMessage();
}

try {
    $memcached = new Memcached;
    $memcached->addServer('memcached', 11211);
    $memcached->set('memcached_key', '<br>Сохранено в memcached');
    echo $memcached->get('memcached_key');

} catch (\Exception $e) {
    echo '<br>memcached не работает: '.$e->getMessage();
}

$connection = pg_connect ("host=db dbname=test_db user=root password=root");
if($connection) {
    $query = pg_query($connection, "SELECT * FROM first_table");
    $result = pg_fetch_array($query);

    echo '<br>'.$result['title'];
} else {
    echo '<br>there has been an error connecting';
}

phpinfo();
?>


</body>
</html>
