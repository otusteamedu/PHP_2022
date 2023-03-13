<?php

namespace Ppro\Hw27\App\Views;

use Ppro\Hw27\App\Application\Request;

interface ViewInterface
{
    public function render(Request $request);
}