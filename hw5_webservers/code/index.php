<?php

require_once("RequestHandler.class.php");

use Validator\RequestHandler;

//echo "Hello, Otus!<br>".date("Y-m-d H:i:s")."<br><br>";
//echo "Handled by PHP-FPM container: " . $_SERVER['HOSTNAME'];

$handler = new RequestHandler();

$handler->handlePostRequest($_POST);

