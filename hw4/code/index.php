<?php

declare(strict_types = 1);

use VeraAdzhieva\Hw4\Request;

$request = new Request();
$request->checkRequest($_POST);
