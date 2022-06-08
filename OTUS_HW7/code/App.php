<?php

declare(strict_types=1);

require 'vendor/autoload.php';

try {
    $App = new \Shilyaev\Chat\App();
    $App->run();
}  catch(\Exception $exception) {
    echo "Произошла ошибка: " . $exception->getMessage();
    exit(1);
}

