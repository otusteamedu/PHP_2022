<?php

declare(strict_types=1);
namespace Mapaxa\EmailVerificationApp\App;

use Mapaxa\EmailVerificationApp\Router;
use Mapaxa\EmailVerificationApp\Exception\RoutesFileException;
use Mapaxa\EmailVerificationApp\HandBook\HttpStatusHandbook;
use Mapaxa\EmailVerificationApp\Service\Http\Response;

class App
{
    private ?Router $router = null;

    public function __construct()
    {
        try {
            $this->router = new Router();
        } catch (RoutesFileException $e) {
            echo $e->getMessage();
            Response::setResponseCode(HttpStatusHandbook::BAD_REQUEST);
            return;
        }
    }

    public function run(): void
    {
        if ($this->router instanceof Router) {
            $this->router->run();
        }
    }
}