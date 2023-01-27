<?php


namespace App\Http\Controllers;


use App\Presenters\ErrorPresenter;
use App\Presenters\Report\ReportStatusPresenter;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ReportStatusQueueController extends Controller
{
    public function __construct(private ReportService $service)
    {
    }

    public function status(int $id): JsonResponse
    {
        try {
            return (new ReportStatusPresenter($this->service->getOne($id)))->present();
        } catch (Throwable $exception) {
            return (new ErrorPresenter($exception))->present();
        }
    }
}
