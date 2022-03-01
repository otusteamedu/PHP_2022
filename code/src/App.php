<?php
declare(strict_types=1);

namespace Decole\NginxBalanceApp;

use Decole\NginxBalanceApp\Controllers\MainController;
use Decole\NginxBalanceApp\Core\Response;
use Exception;

class App
{
    private MainController $controller;

    public function __construct()
    {
        $this->controller = new MainController();
    }

    public function run(): ?string
    {
        try {
            return $this->controller->index();
        } catch (Exception $e) {
            return (new Response())
                ->setData($e->getMessage())
                ->setCode(Response::SERVER_BAD_REQUEST)
                ->getData();
        }
    }
}