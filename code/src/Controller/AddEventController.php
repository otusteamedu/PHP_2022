<?php

declare(strict_types=1);

namespace Otus\App\Controller;

use JsonException;
use Laminas\Diactoros\Response;
use Otus\App\Viewer\Result;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Otus\App\App;

class AddEventController
{
    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $repository = App::getRepositoryController();
        $response   = App::getResponse();

        if ($repository->saveEvent($args['event'])) {
            $response->getBody()->write(Result::EVENT_ADDED_MESSAGE);
            return $response->withStatus(Result::SUCCESS_STATUS);
        }

        $response->getBody()->write(Result::EVENT_NOT_ADDED_MESSAGE);
        return $response->withStatus(Result::FAILURE_STATUS);
    }
}
