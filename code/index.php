<?php
declare(strict_types=1);

use Decole\Hw15\Core\Kernel;

require __DIR__ . '/src/bootstrap/bootstrap.php';

try {
    $app = new Kernel();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage(). PHP_EOL;
}