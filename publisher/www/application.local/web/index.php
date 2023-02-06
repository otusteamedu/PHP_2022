<?php
use app\controllers\Controller;

require __DIR__.'/../vendor/autoload.php';

echo (new Controller())->run();
