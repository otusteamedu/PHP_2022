<?php declare(strict_types=1);

return [
    ['GET', '/', ['Queen\App\Controllers\HomeController', 'index']],
    ['GET', '/form', ['Queen\App\Controllers\FormController', 'index']],
    ['POST', '/form', ['Queen\App\Controllers\FormController', 'index']]
];
