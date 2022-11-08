<?php

declare(strict_types=1);

require __DIR__ . "/vendor/autoload.php";

use Nikcrazy37\ComposerPackage\StringRedactor;

$stringer = new StringRedactor();
echo $stringer->setUpper('some text');