<?php


namespace App\Services;


use App\Services\Dtos\ReportCreateDto;
use App\Services\Dtos\ReportDto;
use Illuminate\Support\Facades\DB;

final class ReportService
{
    public function __construct(private QueueService $service)
    {
    }

    public function create(ReportCreateDto $dto): ReportDto
    {
        DB::transaction(function () use ($dto) {
            DB::insert(
                'insert into reports (name, params, status, created_at, updated_at) values (?, ?, ?, ?, ?)',
                [
                    'test_report',
                    json_encode($dto->getParams(), JSON_THROW_ON_ERROR),
                    'new',
                    date('Y-m-d H:i:s'),
                    date('Y-m-d H:i:s')
                ]
            );
        }, 5);

        $report = DB::table('reports')->orderBy('id', 'desc')->first();

        $reportDto = new ReportDto($report->id, $dto->getParams());

        $this->service->publish($reportDto);

        return $reportDto;
    }
}
