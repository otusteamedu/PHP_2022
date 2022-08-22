<?php

use App\Verificator\EmailVerification;

require_once 'app/library/EmailVerification.php';

echo EmailVerification::selfCheck();

echo EmailVerification::emailIsValid('admin@test,ru') ? 'ok' : 'no';