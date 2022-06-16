<?php

namespace Patterns\App\Infrastructure\Http;

use Patterns\App\Application\Service\AtmService;
use Patterns\App\Application\Service\MoneyIssuingLargeService;
use Patterns\App\Application\Service\MoneyIssuingService;
use Patterns\App\Application\Service\MoneyIssuingSmallService;
use Patterns\App\Application\Service\ProxyService;
use Patterns\App\ContainerFactory;
use Pavelgaponenko\PgOtusComposerPackage\Service\JsonDecoder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AtmController
{

    private ProxyService $proxyService;
    private AtmService $atmService;
    private JsonDecoder $decoder;

    public function __construct()
    {
        $this->atmService = ContainerFactory::getContainer()->get(AtmService::class);
        $this->proxyService = ContainerFactory::getContainer()->get(ProxyService::class);
        $this->decoder = ContainerFactory::getContainer()->get(JsonDecoder::class);
    }

    public function put(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->decoder->toArray($request->getBody()->getContents());

        $result = $this->atmService->put($data['money']);

        $message = $result ? 'Купюры внесены' : 'Возникла ошибка при пополнении';

        return $this->createJsonResponse($response, $message);
    }

    public function give(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->decoder->toArray($request->getBody()->getContents());

        try {
            $result = $this->proxyService->giveOutStrategy($data);
        } catch (\Exception $e) {
            $errorResponse = $response->withStatus($e->getCode());
            return $this->createJsonResponse($errorResponse, $e->getMessage());
        }

        return $this->createJsonResponse($response, $this->decoder->toJson($result));
    }

    private function createJsonResponse(ResponseInterface $response, string $message): ResponseInterface
    {
        $response->getBody()->write($message);

        return $response->withHeader('Content-Type', 'application/json');
    }
}