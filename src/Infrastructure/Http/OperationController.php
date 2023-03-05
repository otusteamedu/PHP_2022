<?php

declare(strict_types=1);

namespace DKozlov\Otus\Infrastructure\Http;

use DateTime;
use DKozlov\Otus\Infrastructure\Http\DTO\RequestInterface;
use DKozlov\Otus\Infrastructure\Http\DTO\ResponseInterface;
use DKozlov\Otus\Infrastructure\Queue\Operation\DTO\CreateOperationMessage;
use DKozlov\Otus\Infrastructure\Queue\Operation\DTO\FindOperationMessage;
use DKozlov\Otus\Infrastructure\Queue\Operation\CreateOperationQueue;
use DKozlov\Otus\Infrastructure\Queue\Operation\DTO\RemoveOperationMessage;
use DKozlov\Otus\Infrastructure\Queue\Operation\FindOperationQueue;
use DKozlov\Otus\Infrastructure\Queue\Operation\RemoveOperationQueue;
use Exception;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      title="Operation API",
 *      version="1.0"
 * )
 */
class OperationController extends AbstractController
{
    public function __construct(
        private readonly CreateOperationQueue $createOperationQueue,
        private readonly FindOperationQueue $findOperationQueue,
        private readonly RemoveOperationQueue $removeOperationQueue
    ) {
        parent::__construct();
    }

    /**
     * @OA\Post(
     *     path="/api/v1/operation/create",
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID of the operation",
     *          required=true
     *     ),
     *     @OA\Parameter(
     *          name="person",
     *          in="query",
     *          description="Person who performed operation",
     *          required=true
     *     ),
     *     @OA\Parameter(
     *          name="amount",
     *          in="query",
     *          description="Amount of the operation",
     *          required=true
     *     ),
     *     @OA\Parameter(
     *          name="date",
     *          in="query",
     *          description="Date of the operation",
     *          required=true
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="If operation successfully created"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="If an error occured durecing executing"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="If missing required parameters"
     *     )
     * )
     */
    public function createOperation(ResponseInterface $response, RequestInterface $request): void
    {
        if (
            $request->has('id')
            && $request->has('person')
            && $request->has('amount')
            && $request->has('date')
        ) {
            try {
                $message = new CreateOperationMessage(
                    (int)$request->get('id'),
                    $request->get('person'),
                    (float)$request->get('amount'),
                    new DateTime($request->get('date'))
                );

                $result = json_decode(
                    $this->createOperationQueue->publishWithResponse($message),
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                );

                $response->withBody($this->json(['success' => $result['success']]));
            } catch (Exception) {
                $response->withCode(500);
            }

        } else {
            $response->withCode(400);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/operation/find",
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the operation",
     *          required=true
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="The operation with transmitted ID"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="If the operation not found"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="If an error occured durecing executing"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="If missing required parameters"
     *     )
     * )
     */
    public function findOperation(ResponseInterface $response, RequestInterface $request): void
    {
        if ($request->has('id')) {
            try {
                $message = new FindOperationMessage((int) $request->get('id'));

                $result = json_decode(
                    $this->findOperationQueue->publishWithResponse($message),
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                );

                if (is_array($result['result'])) {
                    if (empty($result['result'])) {
                        $response->withCode(404);
                    } else {
                        $response->withBody($this->json(['item' => $result['result']]));
                    }
                } else {
                    $response->withCode(500);
                }
            } catch (Exception) {
                $response->withCode(500);
            }
        } else {
            $response->withCode(400);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/operation/remove",
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="ID of the operation",
     *          required=true
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="If operation successfully removed"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="If an error occured durecing executing"
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="If missing required parameters"
     *     )
     * )
     */
    public function removeOperation(ResponseInterface $response, RequestInterface $request): void
    {
        if ($request->has('id')) {
            $message = new RemoveOperationMessage((int) $request->get('id'));

            try {
                $result = json_decode(
                    $this->removeOperationQueue->publishWithResponse($message),
                    true,
                    512,
                    JSON_THROW_ON_ERROR
                );

                $response->withBody($this->json(['success' => $result['success']]));
            } catch (Exception) {
                $response->withCode(500);
            }
        } else {
            $response->withCode(400);
        }
    }
}