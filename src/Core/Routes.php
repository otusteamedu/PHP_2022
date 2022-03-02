<?php declare(strict_types=1);

return [
    ['GET', '/', ['Queen\App\Controllers\HomeController', 'index']],
    ['GET', '/email', ['Queen\App\Controllers\EmailController', 'index']]
];
