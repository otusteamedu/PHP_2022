<?php


namespace App\Http\Controllers;


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

            return response()->json([
                'status' => $report->getReport()->status,
                'reportId' => $report->getReport()->id,
                'params' => $report->getParams(),
            ]);
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage());
        }
    }

    private function getDto(mixed $post): ReportCreateDto
    {
        return new ReportCreateDto($post);
    }
}
