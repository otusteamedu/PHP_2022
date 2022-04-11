<?php


namespace App\Console\Commands\Statistic;


use App\Services\VideoTopStatisticService;
use Illuminate\Console\Command;


class VideoStatisticTopChanelsCommand extends Command
{
    protected $signature = 'el:video:top';

    protected $description = 'Get statistic for top chanel by likes and dislikes';

    public function __construct(private VideoTopStatisticService $service)
    {
        parent::__construct();
    }

    public function handle()
    {
        $count = (int)$this->ask('What count for top channels? - max 5 because channels:  ["Neo", "Morpheus", "Trinity", "Cypher", "Tank"]');

        $this->info("You select {$count} count of top channels");

        $likes = $this->service->calculateLikes($count);
        $dislikes = $this->service->calculateDislikes($count);

        $this->info('Top likes chenals:');
        dump($likes);

        $this->info('Top dislikes chenals:');
        dump($dislikes);

        return 0;
    }
}
