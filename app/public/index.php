<?php

declare(strict_types=1);

use App\Src\Kernel\Kernel;

require_once __DIR__ . '/../../vendor/autoload.php';

$kernel = new Kernel();

$kernel->initializeApiApplication();
