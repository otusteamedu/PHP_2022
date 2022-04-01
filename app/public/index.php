<?php
declare(strict_types=1);

use Nka\Otus\Core\App;

require '../vendor/autoload.php';

try {
    App::init()->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}