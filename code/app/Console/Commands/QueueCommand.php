<?php

namespace App\Console\Commands;

use App\Services\QueueService;
use App\Services\Interfaces\ReportExecuteHandlerInterface;
use Illuminate\Console\Command;

class QueueCommand extends Command
{
    protected $signature = 'cli:report-queue';

    protected $description = 'Report queue handler';

    /**
     * @param QueueService $service
     * @param ReportExecuteHandlerInterface $handler
     */
    public function __construct(private QueueService $service, private ReportExecuteHandlerInterface $handler)
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('Start listening report queue.');

        $this->service->consume($this->handler);
    }
}
