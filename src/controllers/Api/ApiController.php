<?php

declare(strict_types=1);

namespace Controllers\Api;

use OpenApi\Annotations as OA;
use Domain\Contracts\Repository\ApiTaskRepositoryInterface;

final class ApiController
{
    /**
     * @var ApiTaskRepositoryInterface
     */
    private ApiTaskRepositoryInterface $api_task_repository;

    public function __construct()
    {
        $this->api_task_repository = app()->api_task_repository;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/task/{task_uuid}",
     *     security={
     *      { "app_auth": {} },
     *      { "auth": {"write", "read"} }
     *     },
     *     summary="Receive host DNS records",
     *     @OA\Response(
     *         response="200",
     *         description="Record receive",
     *         @OA\JsonContent(
     *             anyOf={
     *                 @OA\Schema(
     *                     ref="#/components/schemas/task_completed"
     *                 ),
     *                 @OA\Schema(
     *                     ref="#/components/schemas/task_pending"
     *                 ),
     *             },
     *             @OA\Examples(
     *                 example="task_completed",
     *                 summary="task completed response",
     *                 ref="#/components/examples/task_completed"
     *             ),
     *             @OA\Examples(
     *                 example="task_pending",
     *                 summary="task pending response",
     *                 ref="#/components/examples/task_pending"
     *             ),
     *         ),
     *     ),
     *     @OA\Parameter(
     *          name="task_uuid",
     *          in="path",
     *          description="uuid (v4) api task",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              @OA\MediaType(
     *                  mediaType="application/json"
     *              )
     *          )
     *     )
     * )
     */
    public function get(string $task_uuid): void
    {
        if (! auth()->user()) {
            response()->json(data: ['error' => 'not authenticated'], code: 422);

            return;
        }

        $api_task_data = $this->api_task_repository->getApiTaskByUuid(uuid: $task_uuid);

        response()->json(
            data: [
                'aaaa_records' => $api_task_data[0]  ?? 'n/a'
            ],
            code: 200
        );
    }
}
