<?php
declare(strict_types=1);

use \Otus\Task06\Core\Application;
use \Otus\Task06\App\Controller;

include __DIR__ . '/vendor/autoload.php';


$application = new Application();
echo $application->run(new Controller($application));




