<?php

declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

use VeraAdzhieva\Hw4\Request;

$request = new Request();
$request->checkRequest($_POST);
