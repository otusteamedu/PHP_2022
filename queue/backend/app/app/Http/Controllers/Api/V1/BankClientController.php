<?php

namespace App\Http\Controllers\Api\V1;

use App\Application\Actions\BankStatement\DTO\GetBankStatementRequest;
use App\Jobs\GetBankStatementJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class BankClientController
{
    public function getBankStatementForClient(
        Request $httpRequest,
        User $user
    ) {
        try {
            dispatch(new GetBankStatementJob(new GetBankStatementRequest(
                $user,
                $httpRequest->json()->get('transferChannel')
            )));

            return new JsonResponse([
                'success' => true,
                'message' => null,
                'payload' => []
            ]);

        } catch (Throwable $e) {
            Log::error($e->getMessage());

            $message = in_array(env('APP_ENV'), ['dev', 'local']) ? $e->getMessage() : 'Unexpected error!';

            return new JsonResponse([
                'success' => false,
                'message' => $message,
                'payload' => null
            ]);
        }
    }
}
