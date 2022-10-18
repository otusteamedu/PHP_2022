<?php

/**
 * The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
 */

namespace App\Jobs;

use App\Models\Task;
use Domain\Services\CheckNumber;
use Domain\ValueObjects\Number;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckNumberJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $jobId;
    protected $number;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $jobId, Number $number)
    {
        $this->jobId = $jobId;
        $this->number = $number;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Здесь непосредственно проверка числа
        $checkSrv = new CheckNumber($this->number);
        $isPrime = $checkSrv->checkPrime();

        //Вывод в консоль для дебага
        echo "Job Getted:".$this->number->getNumber()." is ".($isPrime ? "" : "not ")."prime";

        //Запись результата
        Task::where('uuid', $this->jobId)->update(['result' => $isPrime]);
    }
}
