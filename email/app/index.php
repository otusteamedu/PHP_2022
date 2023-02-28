<?php

use Email\App\Components\ContainerDI;
use Email\App\Core\App;

require 'vendor/autoload.php';

ContainerDI::getContainer()->get(App::class)->run();
