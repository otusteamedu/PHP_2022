<?php

namespace Elastic\App\Controller;

use Elastic\App\Model\Channel;
use Elastic\App\Service\ChannelService;
use Elastic\App\Trait\ContainerFactory;
use Pavelgaponenko\PgOtusComposerPackage\Service\JsonDecoder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ChannelController
{
    use ContainerFactory;

    private ChannelService $service;
    private JsonDecoder $decoder;

    public function __construct()
    {
        $this->service = $this->getContainer()->get(ChannelService::class);
        $this->decoder = $this->getContainer()->get(JsonDecoder::class);
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->decoder->toArray($request->getBody()->getContents());

        $channel = Channel::create()
            ->setId($data['id'])
            ->setName($data['name'])
            ->setDescription($data['description'])
            ->setSubscribers($data['subscribers']);

        $result = $this->service->createChannel($channel);
        $response->getBody()->write($this->decoder->toJson($result));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getQueryParams();
        $channel = $this->service->getChannel($data['index'], $data['id']);
        $response->getBody()->write($this->decoder->toJson($channel->toArray()));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getQueryParams();
        $result = $this->service->deleteChannel($data['index'], $data['id']);
        $response->getBody()->write($this->decoder->toJson($result));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
