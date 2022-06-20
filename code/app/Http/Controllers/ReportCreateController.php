<?php


namespace App\Http\Controllers;


use App\Presenters\ErrorPresenter;
use App\Presenters\Report\ReportCreatePresenter;
use App\Services\Dtos\ReportCreateDto;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final class ReportCreateController extends Controller
{
    public function __construct(private ReportService $service)
    {
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $report = $this->service->create($this->getDto($request->post()));

            return (new ReportCreatePresenter($report))->present();
        } catch (Throwable $exception) {
            return (new ErrorPresenter($exception))->present();
        }
    }

    private function getDto(mixed $post): ReportCreateDto
    {
        return new ReportCreateDto($post);
    }
}
