<?php
declare(strict_types=1);

use Nka\Otus\Core\App;

require '../vendor/autoload.php';

try {
    $appDefinitions = require '../src/boostrap.php';
    App::init($appDefinitions)->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}