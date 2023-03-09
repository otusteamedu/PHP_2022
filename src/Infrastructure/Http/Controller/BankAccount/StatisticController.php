<?php

namespace App\Application\Controller\BankAccount;

use Bitty\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class StatisticController
{
    public function generate(ServerRequestInterface $request): ResponseInterface
    {
        dd($request);
        return new Response('Hello, world!');
    }
}