<?php
declare(strict_types=1);

use Decole\Hw13\Core\Kernel;

require __DIR__ . '/src/bootstrap/bootstrap.php';

$app = new Kernel();
$app->run();