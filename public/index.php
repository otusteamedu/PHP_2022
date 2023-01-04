<?php
declare(strict_types=1);

require dirname(__DIR__).'/vendor/autoload.php';

use AKhakhanova\Hw4\App;

echo "Привет, Otus!<br>" . date("Y-m-d H:i:s") . "<br><br>";

echo "Homework #4";

(new App())->run();