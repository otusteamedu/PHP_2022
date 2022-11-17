<?php
use app\controllers\EmailController;

require __DIR__.'/../vendor/autoload.php';

echo (new EmailController())->run();
