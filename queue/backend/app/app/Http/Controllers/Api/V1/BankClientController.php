<?php

namespace App\Http\Controllers\Api\V1;

use App\Application\Actions\BankStatement\DTO\GetBankStatementRequest;
use App\Jobs\GetBankStatementJob;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Uid\Ulid;
use Throwable;
use Illuminate\Support\Facades\Cache;

class BankClientController
{
    public function getBankStatementForClient(
        Request $httpRequest
    ) {
        $validateTransferChannel = function (Request $httpRequest): string {
            if (   is_string($httpRequest->json()->get('transferChannel'))
                && in_array($httpRequest->json()->get('transferChannel'), ['telegram', 'email'])
            ) {
                return $httpRequest->json()->get('transferChannel');
            }

            throw new \Exception("transferChannel expected string value ['telegram', 'email'] allowed.");
        };

        try {
            $requestId = new Ulid();

            dispatch(new GetBankStatementJob(
                new GetBankStatementRequest(
                    (new User()),
                    $validateTransferChannel($httpRequest)
                ),
                $requestId->toBase32()
            ));

            $getLifeTime = fn() => 500;

            Cache::add($requestId->toBase32(), $requestId->toBase32(), $getLifeTime());

            return new JsonResponse([
                'success' => true,
                'message' => null,
                'payload' => [
                    'requestId' => $requestId->toBase32()
                ]
            ]);

        } catch (Throwable $e) {
            $message = in_array(env('APP_ENV'), ['dev', 'local']) ? $e->getMessage() : 'Unexpected error!';

            return new JsonResponse([
                'success' => false,
                'message' => $message,
                'payload' => null
            ]);
        }
    }

    public function checkRequestStatus(
        Request $httpRequest
    ) {
        try {
            try {
                $requestId = Ulid::fromBase32($httpRequest->json()->get('requestId'));
            } catch (Throwable $e) {
                throw new Exception('requestId expected ulid base32 string format');
            }

            if (!Cache::has($requestId->toBase32())) {
                throw new Exception('request not found!');
            }

            if (Cache::get($requestId->toBase32()) === $requestId->toBase32()) {
                return new JsonResponse([
                    'success' => true,
                    'message' => null,
                    'payload' => [
                        'status' => 'processing',
                        'data' => null
                    ]
                ]);
            }

            return new JsonResponse([
                'success' => true,
                'message' => null,
                'payload' => [
                    'status' => 'ready',
                    'data' => Cache::get($requestId->toBase32())
                ]
            ]);

        } catch (Throwable $e) {
            $message = in_array(env('APP_ENV'), ['dev', 'local']) ? $e->getMessage() : 'Unexpected error!';

            return new JsonResponse([
                'success' => false,
                'message' => $message,
                'payload' => null
            ]);
        }
    }
}
