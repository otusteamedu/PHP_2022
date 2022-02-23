<?php

session_start();

echo "Current nginx container is: {$_SERVER['HOSTNAME']}<br><br>";

echo 'Session ID is: ' . session_id() . '<br><br>';

echo '<hr><br><br>Checking of session in the Memcached:<br><br>';

if ($_SESSION['var']) {
    echo "Value from session: " . $_SESSION['var'];
} else {
    $_SESSION['var'] = 'hello world!';
    echo 'Value added in session, you can reload of page.';
}
