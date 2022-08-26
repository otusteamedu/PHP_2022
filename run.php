<?php
/**
 * @author PozhidaevPro
 * @email pozhidaevpro@gmail.com
 * @Date 22.08.2022 14:21
 */

use Ppro\Hw6\Email;

require 'vendor/autoload.php';

$validator = new Email\Validator('email.txt', true);
$validator->validateFile();
echo 'Валидные адреса:' . PHP_EOL;
var_dump($validator->validEmail);
echo 'Недействительные адреса:' . PHP_EOL;
var_dump($validator->invalidEmail);