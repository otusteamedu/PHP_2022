<?php

namespace KonstantinDmitrienko\App\Controller;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use KonstantinDmitrienko\App\Response as AppResponse;

/**
 * Delete all exist events from storage
 */
class DeleteEventsController
{
    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $repository = new RepositoryController();
        $response   = new Response();

        if ($repository->deleteEvents()) {
            $response->getBody()->write(AppResponse::EVENTS_DELETED_MESSAGE);
            return $response->withStatus(AppResponse::SUCCESS_STATUS);
        }

        $response->getBody()->write(AppResponse::EVENTS_NOT_DELETED_MESSAGE);
        return $response->withStatus(AppResponse::FAILURE_STATUS);
    }
}
