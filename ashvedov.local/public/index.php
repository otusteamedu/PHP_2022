<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Component\Kernel\Kernel;

$kernel_application = new Kernel();

$kernel_application->initializeApplication();
