<?php

declare(strict_types=1);

use Mselyatin\Project15\src\controllers\ShowController;

require("./vendor/autoload.php");

try {
    $controller = new ShowController();
    $controller->runDataMapperSolution();
} catch (\Exception $e) {
    die('Системная ошибка при запуске приложения. Error: ' . $e->getMessage());
}
