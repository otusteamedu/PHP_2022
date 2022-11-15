<?php

require __DIR__ . '/vendor/autoload.php';

use Waisee\StringVerification\Helpers\StringHelper;

$string = $_POST['string'];

$helper = new StringHelper();
return $helper->verify($string);

