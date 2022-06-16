<?php


namespace App\Services;


use App\Services\Dtos\ReportCreateDto;
use App\Services\Dtos\ReportDto;
use Illuminate\Support\Facades\DB;
use JsonException;
use Mockery\Exception;
use stdClass;

final class ReportService
{
    public function __construct(private QueueService $service)
    {
    }

    public function create(ReportCreateDto $dto): ReportDto
    {
        DB::transaction(function () use ($dto) {
            DB::insert(
                'insert into reports (params, status, created_at, updated_at) values (?, ?, ?, ?)',
                [
                    json_encode($dto->getParams(), JSON_THROW_ON_ERROR),
                    QueueService::STATUS_READY,
                    date('Y-m-d H:i:s'),
                    date('Y-m-d H:i:s')
                ]
            );
        }, 5);

        $report = DB::table('reports')->orderBy('id', 'desc')->first();

        $reportDto = new ReportDto($report, $dto->getParams());

        $this->service->publish($reportDto);

        return $reportDto;
    }

    /**
     * @throws JsonException
     */
    public function process(int $id): void
    {
        $report = DB::select('select * from reports where id = :id limit 1', ['id' => $id]);

        if (empty($report)) {
            return;
        }

        $processed = md5(json_encode($report[0]->params, JSON_THROW_ON_ERROR));

        DB::update(
            "update reports set compiled_data = '{$processed}' where id = ?",
            [$id]
        );
    }

    public function setInQueue(int $id, string $status): void
    {
        DB::update(
            "update reports set status = '{$status}' where id = ?",
            [$id]
        );
    }

    public function getOne(int $id): stdClass
    {
        $report = DB::table('reports')
            ->where('id', '=', $id)
            ->orderBy('id', 'desc')
            ->first();

        if ($report === null) {
            throw new Exception('report not found');
        }

        return $report;
    }
}
