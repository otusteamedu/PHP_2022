<?php

namespace App\Presenters;

use Illuminate\Http\JsonResponse;

abstract class AbstractPresenter implements PresenterInterface
{
    abstract public function getResult(): array;

    /**
     * @return JsonResponse
     */
    public function present(): JsonResponse
    {
        return response()->json($this->getResult());
    }
}
