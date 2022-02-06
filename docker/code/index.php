<?php
error_reporting(E_ALL & ~E_NOTICE);

$memcached = new Memcached;

$memcached->addServer('memcached', 11211);

echo '<pre>'; print_r($memcached->getServerList()); echo '</pre>';

if($memcached->getStats() === false) {
    echo 'returned false';
} else {
    echo '<pre>'; print_r($memcached->getStats()); echo '</pre>';
}

phpinfo();