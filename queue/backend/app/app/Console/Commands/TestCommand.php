<?php

namespace App\Console\Commands;

use App\Jobs\GetBankStatementJob;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    protected $signature = 'app:test';

    protected $description = '';

    public function handle()
    {
        try {
            dispatch(new GetBankStatementJob());
        } catch (\Throwable $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }
}
