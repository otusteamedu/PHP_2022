<?php

use app\controllers\AppController;

require '../vendor/autoload.php';

echo (new AppController())->run();
