<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Component\Kernel\Kernel;

$kernel = new Kernel();

$kernel->initializeApplication();
