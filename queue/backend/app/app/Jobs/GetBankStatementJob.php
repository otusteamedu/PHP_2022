<?php

namespace App\Jobs;

use App\Application;
use Illuminate\Support\Facades\Log;
use Throwable;

class GetBankStatementJob extends Job
{
    private Application\Contracts\GetBankStatementRequestInterface $request;

    public function __construct(
        Application\Contracts\GetBankStatementRequestInterface $request
    ) {
        $this->request = $request;
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
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }
    }
}
