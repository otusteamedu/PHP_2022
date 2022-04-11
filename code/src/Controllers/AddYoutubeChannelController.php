<?php

namespace KonstantinDmitrienko\App\Controllers;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use KonstantinDmitrienko\App\Response as AppResponse;

/**
 * Adding of the YouTube channel controller
 */
class AddYoutubeChannelController
{
    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $name = $request->getParsedBody()['youtube']['name'];

        $controller = new AppController();
        $controller->addYoutubeChannel($name);

        $response = new Response;
        $response->getBody()->write(AppResponse::CHANNEL_ADDED_MESSAGE);

        return $response->withStatus(AppResponse::SUCCESS_STATUS);
    }
}
