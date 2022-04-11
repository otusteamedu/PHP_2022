<?php

namespace KonstantinDmitrienko\App\Controllers;

use JsonException;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use KonstantinDmitrienko\App\Response as AppResponse;

/**
 * Get all Youtube channels with likes/dislikes
 */
class GetAllChannelsController
{
    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     * @throws JsonException
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $controller = new AppController();

        $response = new Response;
        $response->getBody()->write(json_encode(
            $controller->getAllChannelsInfo(), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT
        ));

        return $response->withAddedHeader(AppResponse::JSON_HEADER_NAME, AppResponse::JSON_HEADER_VALUE)
            ->withStatus(AppResponse::SUCCESS_STATUS);
    }
}
