<?php

declare(strict_types=1);

use Mselyatin\Project15\src\controllers\ShowController;

require("../vendor/autoload.php");

$controller = new ShowController();
$controller->runDataMapperSolution();
