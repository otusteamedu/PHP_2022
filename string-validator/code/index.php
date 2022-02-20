<?php

use KonstantinDmitrienko\StringValidator\App\App;

require 'vendor/autoload.php';

$app = new App();

if ($app->getPost()) {
    $app->validateString();
} else {
    $app->showInputField();
}
