<?php

declare(strict_types=1);

namespace Controllers\DnsRecords;

use OpenApi\Annotations as OA;
use ApplicationContracts\Queue\QueuePublisherGateway;
use Domain\Contracts\Repository\ApiTaskRepositoryInterface;

final class DnsRecordsController
{
    /**
     * @var ApiTaskRepositoryInterface
     */
    private ApiTaskRepositoryInterface $api_task_repository;

    /**
     * @var QueuePublisherGateway
     */
    private QueuePublisherGateway $queue_publisher;

    public function __construct()
    {
        $this->api_task_repository = app()->api_task_repository;
        $this->queue_publisher = app()->queue_publisher;
    }

    /**
     * @param string $host
     * @return void
     *
     * @OA\Post(
     *     path="/api/v1/dns-records/{host}",
     *     security={
     *      { "app_auth": {} },
     *      { "auth": {"write", "read"} }
     *     },
     *     summary="Start api task for receive host DNS records",
     *     @OA\Response(
     *          response="200",
     *          description="receive task uuid",
     *          @OA\JsonContent(
     *              ref="#/components/schemas/task_uuid"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="host",
     *          in="path",
     *          description="site domain name",
     *          example="www.example.com",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     )
     * )
     */
    public function get(string $host): void
    {
        if (! auth()->user()) {
            response()->json(data: ['error' => 'not authenticated'], code: 422);

            return;
        }

        $uuid = $this->api_task_repository->createApiTask();

        $this->queue_publisher
            ->publish(
                queue_name: $_ENV['QUEUE_NAME'],
                routing_key: $_ENV['QUEUE_ROUTING_KEY'],
                request_body: json_encode(['host' => $host, 'uuid' => $uuid])
            );

        response()->json(data: ['uuid' => $uuid], code: 200);
    }
}
