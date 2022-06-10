<?php

declare(strict_types=1);


namespace Mapaxa\EmailVerificationApp\Dto;


class Track
{
    public $controller;
    public $action;

    public function __construct(string $controller, string $action)
    {
        $this->controller = $controller;
        $this->action = $action;
    }


}