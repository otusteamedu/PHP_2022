<?php

use Kopte\Code\Components\Route;
use Kopte\Code\Components\StringController;

Route::post('/', [StringController::class, 'verify']);
