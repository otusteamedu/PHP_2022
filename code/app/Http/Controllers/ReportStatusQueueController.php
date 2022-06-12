<?php


namespace App\Http\Controllers;


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
            $report = $this->service->getOne($id);

            return response()->json([
                'reportId' => $id,
                'status' => $report->status,
                'created_at' => $report->created_at,
            ]);
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage());
        }
    }
}
