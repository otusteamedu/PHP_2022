<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Component\Http\Response;

abstract class AbstractController
{
    protected function renderView(string $view, array $parameters = []): string
    {
        return file_get_contents(BASE_PATH.$view);
    }

    protected function render(string $view, array $parameters = [], Response $response = null): Response
    {
        $content = $this->renderView($view, $parameters);

        if (null === $response) {
            $response = new Response();
        }

        $response->setContent($content);

        return $response;
    }
}