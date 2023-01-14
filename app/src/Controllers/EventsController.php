<?php

namespace Octopus\App\Controllers;

use Octopus\App\Storage\Interfaces\StorageInterface;
use Octopus\App\Traits\HttpResponseTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EventsController
{
    use HttpResponseTrait;

    private StorageInterface $storage;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $params = json_decode($request->getBody()->getContents(), true);
            $this->storage->add($params);

            return $this->successResponse($response);
        } catch (\Exception $e) {
            return $this->errorResponse(
                $response,
                $e->getMessage(),
                100,
            );
        }
    }

    public function truncate(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $this->storage->truncate();

            return $this->successResponse($response);
        } catch (\Exception $e) {
            return $this->errorResponse(
                $response,
                $e->getMessage(),
                100,
            );
        }
    }

    public function show(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $params = json_decode($request->getBody()->getContents(), true);
            $res = $this->storage->get($params);

            return $this->jsonResponse($response, $res);
        } catch (\Exception $e) {
            return $this->errorResponse(
                $response,
                $e->getMessage(),
                100,
            );
        }
    }
}
