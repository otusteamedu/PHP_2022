<?php

namespace App\Presenters;

use Illuminate\Http\JsonResponse;
use Throwable;

class ErrorPresenter implements PresenterInterface
{
    /**
     * @param Throwable $exception
     */
    public function __construct(private Throwable $exception)
    {
    }

    /**
     * @return JsonResponse
     */
    public function present(): JsonResponse
    {
        return response()->json($this->exception->getMessage());
    }
}
