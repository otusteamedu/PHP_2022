<?php

use app\Infrastructure\Http\Controller\RestaurantController;

require __DIR__.'/../vendor/autoload.php';

echo (new RestaurantController())->run();
