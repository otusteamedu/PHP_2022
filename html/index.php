<?php

echo 'OK IT IS GOOD';
echo '<hr>';

if(function_exists('curl_init') === false){
    echo 'CURL DISABLED';
}
echo '<hr>';

try
{
    $redis = new Redis();
    $redis->connect('127.0.0.1', 1504);
    echo $redis->ping();
}
catch(\Throwable $e)
{
    echo 'Redis Class NO Exist';
}
echo '<hr>';
try {
    $dbhost = 'localhost';
    $dbname = 'root';
    $dbuser = 'root';
    $dbpass = 'root';


    $link = mysqli_connect($dbhost, $dbuser, $dbpass) or die('Error connecting to mysql: '.mysql_error());
    mysqli_select_db($link, $dbname);

    $test_query = "SHOW TABLES FROM $dbname";
    $result = mysqli_query($link, $test_query);
} catch (\Throwable $e){

}

echo '<hr>';
try {
    $memcached = new Memcached();
    $memcached->setOption(Memcached::OPT_DISTRIBUTION, Memcached::DISTRIBUTION_MODULA);
    $memcached->addServers([
        ['memcached1', 11211],
        ['memcached2', 11211]
    ]);
} catch (\Throwable $th) {
    //throw $th;
    echo 'Err memcahed';
}

phpinfo();
