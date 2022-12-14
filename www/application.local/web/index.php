<?php
use app\controllers\AppController;

require __DIR__.'/../vendor/autoload.php';

echo (new AppController())->run();
