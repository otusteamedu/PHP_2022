<?php

require_once('./src/ValidatorRequest.php');
require_once('./src/ValidatorResponse.php');

use Onbalt\Validator\ValidatorRequest;
use Onbalt\Validator\ValidatorResponse;

$requestHandler = new ValidatorRequest();
$resultIsValid = $requestHandler->handleRequest($_REQUEST);

$responseHandler = new ValidatorResponse($resultIsValid);
$responseHandler->flushResponse();