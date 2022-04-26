<?php

namespace KonstantinDmitrienko\App\Controller;

use JsonException;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use KonstantinDmitrienko\App\Response as AppResponse;

/**
 * Get all related events from storage
 */
class GetEventsController
{
    /**
     * @param ServerRequestInterface $request
     * @param array                  $args
     *
     * @return ResponseInterface
     * @throws JsonException
     */
    public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $repository = new RepositoryController();
        $response   = new Response();

        if ($event = $repository->getEvent($args['params'])) {
            $response->getBody()->write(json_encode($event, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT));
            return $response->withAddedHeader(AppResponse::JSON_HEADER_NAME, AppResponse::JSON_HEADER_VALUE)
                ->withStatus(AppResponse::SUCCESS_STATUS);
        }

        $response->getBody()->write(AppResponse::EVENT_NOT_FOUND_MESSAGE);
        return $response->withStatus(AppResponse::FAILURE_STATUS);
    }
}
