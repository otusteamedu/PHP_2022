<?php

use Otus\Core\Application\App;
const PATH_APP = __DIR__ . '/../';

require_once __DIR__ . '/../vendor/autoload.php';

App::make()->run();