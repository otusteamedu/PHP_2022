<?php
declare(strict_types=1);

use \Otus\Task12\Core\Application;
echo '<pre>';
include __DIR__ . '/vendor/autoload.php';

$application = new Application();
$application->run();