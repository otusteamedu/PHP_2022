<?php

require_once __DIR__ . '/../vendor/autoload.php';

//session_start();

use App\Component\Kernel\Kernel;

$kernel_application = new Kernel();

/*echo 'Hello world!';
echo '<br>';
echo 'Host name: ' . $_SERVER['HOSTNAME'];
echo '<br>';
echo 'Host IP: ' . $_SERVER['SERVER_ADDR'];
echo '<br>';
echo 'Host port: ' . $_SERVER['SERVER_PORT'];
echo '<br>';

echo 'Session ID: ' . session_id();
echo '<br>';
echo '<hr>';

$_SESSION['server_hostname'] = $_SERVER['HOSTNAME'];
echo 'Server hostname added in session, you can reload of page.';

echo '<br>';

echo 'Checking of session in the Memcached:';
echo '<br>';

if ($_SESSION['server_hostname']) {
    echo "Value from session: " . $_SESSION['server_hostname'];
}

echo '<br>';*/

$kernel_application->initializeApplication();
