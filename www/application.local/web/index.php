<?php
use app\controllers\EmailController;

require __DIR__.'/../vendor/autoload.php';

(new EmailController())->run();
