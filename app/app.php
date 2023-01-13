<?php

use app\Infrastructure\Command\AppController;

require_once('./vendor/autoload.php');

(new AppController())->run();
