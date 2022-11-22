<?php

declare(strict_types=1);

namespace Otus\App\Controller;

use Laminas\Diactoros\Response;
use Otus\App\Viewer\Result;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteEventsController
{
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $repository = new RepositoryController();
        $response   = new Response();

        if ($repository->deleteEvents()) {
            $response->getBody()->write(Result::EVENTS_DELETED_MESSAGE);
            return $response->withStatus(Result::SUCCESS_STATUS);
        }

        $response->getBody()->write(Result::EVENTS_NOT_DELETED_MESSAGE);
        return $response->withStatus(Result::FAILURE_STATUS);
    }
}
