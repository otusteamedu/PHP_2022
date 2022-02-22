<?php
require './vendor/autoload.php';
session_start();
echo 'Session: ' . session_id() . '<br>';
echo sprintf("Container ID: %s", $_SERVER['HOSTNAME']);
