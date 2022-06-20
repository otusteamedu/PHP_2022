<?php


namespace App\Presenters;


use Illuminate\Http\JsonResponse;

interface PresenterInterface
{
    public function present(): JsonResponse;
}
