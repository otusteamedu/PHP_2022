<?php

use Koptev\Controllers\VerificationController;
use Koptev\Support\Route;

Route::post('/verify-email', [VerificationController::class, 'verifyEmail']);
