<?php

declare(strict_types=1);
const ROOT = __DIR__ . "/../..";
require ROOT . "/vendor/autoload.php";

$openapi = \OpenApi\Generator::scan([ROOT . "/src"]);
$content = $openapi->toJson();

if (file_put_contents("openapi.json", $content)) {
    die("success");
}

die("failed");