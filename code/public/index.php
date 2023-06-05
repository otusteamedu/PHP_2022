<?php

declare(strict_types=1);
const ROOT = __DIR__ . "/..";

use Nikcrazy37\Hw16\WebApp;

require ROOT . "/vendor/autoload.php";

(new WebApp())->run();