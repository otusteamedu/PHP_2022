<?php


namespace App\Http\Controllers;


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
            $report = $this->service->getOne($id);

            return response()->json([
                'reportId' => $id,
                'result' => $report->compiled_data,
                'status' => $report->status,
                'params' => json_decode($report->params, true, 512, JSON_THROW_ON_ERROR),
                'created_at' => $report->created_at,
                'updated_at' => $report->updated_at,
            ]);
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage());
        }
    }
}
