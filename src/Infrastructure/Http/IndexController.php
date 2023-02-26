<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Http;

use DKozlov\Otus\Infrastructure\Http\DTO\ResponseInterface;

class IndexController extends AbstractController
{
    public function home(ResponseInterface $response): void
    {
        $response->withBody($this->view('home.php'));
    }
}