<?php

namespace App\Http\Controllers;

use App\Services\Dtos\ReportCreateDto;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportCreateController extends Controller
{
    public function __construct(private ReportService $service)
    {
    }

    public function store(Request $request): JsonResponse
    {
        $reportId = $this->service->create($this->getDto($request->post()));

        return response()->json(['reportId' => $reportId]);
    }

    private function getDto(mixed $post): ReportCreateDto
    {
        return new ReportCreateDto($post);
    }
}
