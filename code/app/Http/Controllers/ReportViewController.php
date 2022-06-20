<?php


namespace App\Http\Controllers;


use App\Presenters\ErrorPresenter;
use App\Presenters\Report\ReportViewPresenter;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Throwable;

final class ReportViewController extends Controller
{
    public function __construct(private ReportService $service)
    {
    }

    public function view(int $id): JsonResponse
    {
        try {
            return (new ReportViewPresenter($this->service->getOne($id)))->present();
        } catch (Throwable $exception) {
            return (new ErrorPresenter($exception))->present();
        }
    }
}
