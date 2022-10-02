<?php

namespace App\Jobs;

use App\Application;
use DateInterval;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Support\Facades\Cache;

class GetBankStatementJob extends Job
{
    private Application\Contracts\GetBankStatementRequestInterface $request;

    private string $requestId;

    public function __construct(
        Application\Contracts\GetBankStatementRequestInterface $request,
        string $requestId
    ) {
        $this->request = $request;
        $this->requestId = $requestId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(
        Application\Contracts\GetBankStatementInterface $getBankStatementAction
    ) {
        try {
            $response = $getBankStatementAction->get($this->request);
            sleep(30); // имитируем работу для ожидания и проверки статуса
            Cache::put($this->requestId, json_encode($response->getData()), 300);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }
    }
}
