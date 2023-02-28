<?php

namespace App\Modules\Queries\Application;

use App\Jobs\Job;
use App\Modules\Queries\Domain\Query;
use App\Modules\Queries\Domain\QueryStatusEnum;

class QueryJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public Query $query)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->query->status = QueryStatusEnum::processed;
        $this->query->save();

        sleep(10);

        $this->query->status = QueryStatusEnum::ready;
        $this->query->save();
    }
}
