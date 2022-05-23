<?php
require 'src/autoload.php';
$request = new \PShilyaev\Request();
$app = new \PShilyaev\App($request);
$response = $app->Run($request);
http_response_code($response->getStatus());
echo $response->getMessage();

