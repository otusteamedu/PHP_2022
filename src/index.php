<?php

use Src\Infrastructure\EmailValidatorController;

require_once __DIR__ . '/../vendor/autoload.php';

$email_validator = new EmailValidatorController();

try {
    $email_validator->validate(raw_email: 23);
} catch (\Exception $exception) {
    echo "<b>" .  $exception->getMessage() . "</b>";
}
