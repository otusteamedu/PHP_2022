<?php

declare(strict_types=1);

namespace Otus\App\Controller;

use JsonException;
use Laminas\Diactoros\Response;
use Otus\App\Viewer\Result;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Otus\App\App;

class GetEventsController
{
    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $repository = App::getRepositoryController();
        $response   = App::getResponse();


        if ($event = $repository->getEvent($args['params'])) {
            $response->getBody()->write(json_encode($event, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
            return $response->withAddedHeader(Result::JSON_HEADER_NAME, Result::JSON_HEADER_VALUE)
                ->withStatus(Result::SUCCESS_STATUS);
        }

        $response->getBody()->write(Result::EVENT_NOT_FOUND_MESSAGE);
        return $response->withStatus(Result::FAILURE_STATUS);
    }
}
