<?php

namespace Elastic\App\Controller;

use Elastic\App\Model\Video;
use Elastic\App\Service\VideoService;
use Elastic\App\Trait\ContainerFactory;
use Pavelgaponenko\PgOtusComposerPackage\Service\JsonDecoder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VideoController
{
    use ContainerFactory;

    private VideoService $service;
    private JsonDecoder $decoder;

    public function __construct()
    {
        $this->service = $this->getContainer()->get(VideoService::class);
        $this->decoder = $this->getContainer()->get(JsonDecoder::class);
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->decoder->toArray($request->getBody()->getContents());

        $video = Video::create()
            ->setId($data['id'])
            ->setName($data['name'])
            ->setDescription($data['description'])
            ->setTime($data['time'])
            ->setChannelId($data['channelId']);

        $result = $this->service->addVideo($video);
        $response->getBody()->write($this->decoder->toJson($result));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getQueryParams();
        $video = $this->service->getVideo($data['index'], $data['id']);
        $response->getBody()->write($this->decoder->toJson($video->toArray()));

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getQueryParams();
        $result = $this->service->deleteVideo($data['index'], $data['id']);
        $response->getBody()->write($this->decoder->toJson($result));

        return $response->withHeader('Content-Type', 'application/json');
    }
}