<?php
declare(strict_types=1);

namespace Decole\NginxBalanceApp;

use Decole\NginxBalanceApp\Controllers\MainController;

class App
{
    private MainController $controller;

    public function __construct()
    {
        $this->controller = new MainController();
    }

    public function run(): ?string
    {
        return $this->controller->index();
    }
}