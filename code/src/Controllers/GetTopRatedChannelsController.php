<?php

namespace KonstantinDmitrienko\App\Controllers;

use JsonException;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use KonstantinDmitrienko\App\Response as AppResponse;

/**
 * Get top-rated YouTube channels by limit
 */
class GetTopRatedChannelsController
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
            $controller->getTopRatedChannels(), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT
        ));

        return $response->withAddedHeader(AppResponse::JSON_HEADER_NAME, AppResponse::JSON_HEADER_VALUE)
            ->withStatus(AppResponse::SUCCESS_STATUS);
    }
}
