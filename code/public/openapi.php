<?php

declare(strict_types=1);
const ROOT = __DIR__ . "/..";
require ROOT . "/vendor/autoload.php";

$openapi = \OpenApi\Generator::scan([ROOT . "/src"]);

header('Content-Type: application/x-yaml');
echo $openapi->toYaml();