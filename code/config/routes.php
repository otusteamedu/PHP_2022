<?php

use Koptev\Support\Route;
use Koptev\Controllers\StringController;

Route::post('/', [StringController::class, 'verify']);
