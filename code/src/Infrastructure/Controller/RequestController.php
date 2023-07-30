<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw20\Infrastructure\Controller;

use Nikcrazy37\Hw20\Application\Request\ProcessRequest;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use DI\Container;
use Nikcrazy37\Hw20\Infrastructure\Queue\Sender;
use OpenApi\Attributes as OA;

#[OA\Server('/api/v1')]
#[OA\Info(version: '0.1', title: 'Request API')]
#[OA\Components(
    schemas: [
        new OA\Schema(
            schema: "Response",
            description: "uid",
            type: "string"
        ),
        new OA\Schema(
            schema: "ResponseStatus",
            description: "status",
            type: "string"
        )
    ]
)]
class RequestController
{
    private Container $container;
    private ProcessRequest $processRequest;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->processRequest = $this->container->get(ProcessRequest::class);
    }

    #[OA\Post(
        path: '/request',
        operationId: 'send',
        description: 'Создаёт новый запрос в системе',
        responses: [
            new OA\Response(
                response: 200,
                description: 'Запрос создан в системе',
                content: new OA\MediaType(
                    mediaType: 'string',
                    schema: new OA\Schema(ref: '#/components/schemas/Response')
                )
            )
        ]
    )]
    public function send(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $uid = uniqid("", true);

        ($this->container->get(ProcessRequest::class))->createRequest($uid);
        ($this->container->get(Sender::class))->execute($uid);

        $response->getBody()->write($uid);
        return $response;
    }

    #[OA\Get(
        path: '/request/{uid}',
        operationId: 'check',
        description: 'Проверяет состояние запроса в системе',
        parameters: [
            new OA\Parameter(
                name: 'uid',
                description: 'Идентификатор запроса в системе',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Запрос создан в системе',
                content: new OA\MediaType(
                    mediaType: 'string',
                    schema: new OA\Schema(ref: '#/components/schemas/ResponseStatus')
                )
            )
        ],
    )]
    public function check(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $uid = $args["uid"];
        $status = $this->processRequest->checkRequest($uid);

        $response->getBody()->write($status);
        return $response;
    }
}