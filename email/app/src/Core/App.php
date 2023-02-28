<?php

namespace Email\App\Core;

use Email\App\Controller\ValidateController;

class App
{
    private ValidateController $validateController;

    public function __construct(ValidateController $validateController)
    {
        $this->validateController = $validateController;
    }

    public function run(): void
    {
        $this->validateController->validateEmail();
    }
}