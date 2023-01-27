<?php

namespace App\Presenters;

use Illuminate\Http\JsonResponse;

interface PresenterInterface
{
    /**
     * @return JsonResponse
     */
    public function present(): JsonResponse;
}
