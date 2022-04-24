<?php

use Decole\Hw15\Controllers\AppController;

/**
 * see routing lib: https://github.com/klein/klein.php
 *
 * ['GET', '/posts', $callback],
 * ['POST', '/posts', $callback],
 * ['PUT', '/posts/[i:id]', $callback],
 * ['DELETE', '/posts/[i:id]', $callback],
 * ['OPTIONS', null, $callback],
 */
return [
    ['GET', '/', function ($request, $response) {(new AppController())->index($response);}],
];