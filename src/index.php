<?php

include ('../vendor/autoload.php');

use TemaGo\OtusTest\NumberParser;

$parser = new NumberParser();
$phone = $parser->parse('Привет, мой номер телефона - 8 999 888 77 66');
echo ($phone);
