<?php

namespace KonstantinDmitrienko\App\Controller;

use JsonException;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use KonstantinDmitrienko\App\Response as AppResponse;

/**
 * Adding the event controller
 */
class AddEventController
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

        if ($repository->saveEvent($args['event'])) {
            $response->getBody()->write(AppResponse::EVENT_ADDED_MESSAGE);
            return $response->withStatus(AppResponse::SUCCESS_STATUS);
        }

        $response->getBody()->write(AppResponse::EVENT_NOT_ADDED_MESSAGE);
        return $response->withStatus(AppResponse::FAILURE_STATUS);
    }
}
