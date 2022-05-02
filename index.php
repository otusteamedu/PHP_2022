<?php

use App\Validator\ValidatorFactory;

require_once './vendor/autoload.php';


$validator = ValidatorFactory::createByEmail();
$validator->validate('emails.txt');
