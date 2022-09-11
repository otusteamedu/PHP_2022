<?php
/**
 * @author PozhidaevPro
 * @email pozhidaevpro@gmail.com
 * @Date 22.08.2022 14:21
 */

use Ppro\Hw4\Email;

require 'vendor/autoload.php';

$validator = new Email\Validator('email.txt', true);
var_dump($validator->validate());

$emailValidator = new Email\Validator();
echo $emailValidator->validateEmail('test@ya.ru');