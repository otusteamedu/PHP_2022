<?php

declare(strict_types=1);

use App\App;

require_once dirname(__DIR__).'/vendor/autoload.php';

$application = new App();

echo $application->run();