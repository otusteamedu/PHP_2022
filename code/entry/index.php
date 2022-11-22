<?php

declare(strict_types=1);
const ROOT = __DIR__ . "/..";

use Nikcrazy37\Hw5\App;

require ROOT . "/vendor/autoload.php";

$router = new App();
$router->run();