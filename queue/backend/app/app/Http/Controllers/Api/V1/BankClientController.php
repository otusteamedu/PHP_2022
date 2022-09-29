<?php

namespace App\Http\Controllers\Api\V1;

use App\Application\Actions\BankStatement\DTO\GetBankStatementRequest;
use App\Jobs\GetBankStatementJob;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

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
            dispatch(new GetBankStatementJob(new GetBankStatementRequest(
                (new User()),
                $validateTransferChannel($httpRequest)
            )));

            return new JsonResponse([
                'success' => true,
                'message' => null,
                'payload' => null
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
