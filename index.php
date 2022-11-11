<?php

declare(strict_types=1);

use EliasJump\PasswordGenerator\PasswordGenerator;

require __DIR__.'/vendor/autoload.php';

$generator = new PasswordGenerator();
echo $generator->run(6) . PHP_EOL;
