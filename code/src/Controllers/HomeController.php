<?php

namespace KonstantinDmitrienko\App\Controllers;

use KonstantinDmitrienko\App\View;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Home page controller
 */
class HomeController
{
    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response;
        $response->getBody()->write((new View())->getForm());
        return $response;
    }
}
