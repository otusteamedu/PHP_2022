<?php


namespace App\Presenters;


use Illuminate\Http\JsonResponse;
use Throwable;

class ErrorPresenter implements PresenterInterface
{
    public function __construct(private Throwable $exception)
    {
    }

    public function present(): JsonResponse
    {
        return response()->json($this->exception->getMessage());
    }
}
