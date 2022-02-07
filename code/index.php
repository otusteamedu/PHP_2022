<?php

echo "Привет, Maksim!<br>".date("Y-m-d H:i:s");


error_reporting(E_ALL & ~E_NOTICE);

$redis = new Redis(); 
$redis->connect('redis', 6379); 
echo "<br><br>Connection to server Redis sucessfully"; 
//check whether server is running or not 

$memcached = new Memcached; 

$memcached->addServer('memcached', 11211);


echo '<pre>'; print_r($memcached->getServerList()); echo '</pre>';

if($memcached->getStats() === false) {
    echo 'returned false';
} else {
    echo "<br>Connection to server Memcached sucessfully"; 
    echo '<pre>'; print_r($memcached->getStats()); echo '</pre>';
}


//phpinfo();