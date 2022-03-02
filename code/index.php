<?php
declare(strict_types=1);

use Decole\NginxBalanceApp\App;

require __DIR__ . '/src/bootstrap/bootstrap.php';

$app = new App();
echo $app->run();
