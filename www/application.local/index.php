<?php

declare(strict_types=1);

require '/vendor/autoload.php';

use Rehkzylbz\OtusHw4\SessionProvider;
use Rehkzylbz\OtusHw4\RequestProvider;
use Rehkzylbz\OtusHw4\StringValidator;
use Rehkzylbz\OtusHw4\ResponseProvider;

$session = (new SessionProvider('memcached'))->start();
$string = (new RequestProvider())->get_post_parameter('string', ')(');
$validation = (new StringValidator())->is_valid_parenthesis($string);
(new ResponseProvider($validation))->send($session->get_info_message());
