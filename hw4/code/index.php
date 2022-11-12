<?php

declare(strict_types = 1);

require_once("Request.php");

use Request\Request;

$request = new Request();
$request->checkRequest($_POST);
