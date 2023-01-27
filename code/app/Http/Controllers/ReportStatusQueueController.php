<?php

namespace App\Http\Controllers;

use App\Presenters\ErrorPresenter;
use App\Presenters\Report\ReportStatusPresenter;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ReportStatusQueueController extends Controller
{
    /**
     * @param ReportService $service
     */
    public function __construct(private ReportService $service)
    {
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse
    {
        try {
            return (new ReportStatusPresenter($this->service->getOne($id)))->present();
        } catch (Throwable $exception) {
            return (new ErrorPresenter($exception))->present();
        }
    }
}
