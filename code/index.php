<?php
declare(strict_types=1);

use Decole\NginxBalanceApp\App;

require __DIR__ . '/src/bootstrap/bootstrap.php';

$app = new App();
echo $app->run();

//echo "Привет, Otus!<br>".date("Y-m-d H:i:s")."<br><br>";

//echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];