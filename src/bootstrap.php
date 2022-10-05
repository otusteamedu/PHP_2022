<?php

declare(strict_types=1);

require_once dirname(__FILE__) . '/../vendor/autoload.php';

$config = new \App\Common\Config();
$messenger = new \App\Messengers\SmtpSender($config);

