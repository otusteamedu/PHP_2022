<?php

namespace Anosovm\HW5\Controllers;

use Anosovm\HW5\Services\ValidationService;

class ValidatorController extends Controller
{
    public function __construct(
        public ValidationService $validator
    )
    {
        $this->view = 'Views/validator.php';
        $this->data = $validator->validateEmail();
    }
}