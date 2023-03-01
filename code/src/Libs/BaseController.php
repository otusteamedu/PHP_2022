<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Libs;

abstract class BaseController
{
    protected Request $request;
    protected AbstractView $view;

    public function __construct()
    {
        $this->request = new Request();
    }
}