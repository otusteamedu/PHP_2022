<?php

namespace Elastic\App\Controller;

use Elastic\App\Service\StatisticService;
use Elastic\App\Trait\ContainerFactory;
use Pavelgaponenko\PgOtusComposerPackage\Service\JsonDecoder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class InfoController
{
    use ContainerFactory;

    private StatisticService $service;
    private JsonDecoder $decoder;

    public function __construct()
    {
        $this->service = $this->getContainer()->get(StatisticService::class);
        $this->decoder = $this->getContainer()->get(JsonDecoder::class);
    }

    public function getChannelLikes(ServerRequestInterface $request, ResponseInterface $response)
    {
        $data = $request->getQueryParams();
        $info = $this->service->getChannelLikes((string)$data['channelId']);
        $response->getBody()->write($this->decoder->toJson($info));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getTopChannels(ServerRequestInterface $request, ResponseInterface $response)
    {
        $data = $request->getQueryParams();
        $info = $this->service->getTopChannels((int)$data['limit']);
        $response->getBody()->write($this->decoder->toJson($info));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
