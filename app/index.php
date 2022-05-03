<?php

declare(strict_types=1);

use Mselyatin\Project6\src\classes\Application;

require("../vendor/autoload.php");

$config = include('config/config.php');
$app = Application::create($config);
$app->run();

