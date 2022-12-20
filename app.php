<?php
declare(strict_types=1);

use \Otus\Task07\Core\Application;
use \Otus\Task07\App\Controller;

include __DIR__ . '/vendor/autoload.php';


$application = new Application();
$application->run(new Controller($application));




