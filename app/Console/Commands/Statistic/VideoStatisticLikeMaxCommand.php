<?php


namespace App\Console\Commands\Statistic;


use App\Services\VideoStatisticService;
use Illuminate\Console\Command;

class VideoStatisticLikeMaxCommand extends Command
{
    protected $signature = 'el:video:max';

    protected $description = 'Get statistic for max likes and dislikes on chanel';

    public function __construct(private VideoStatisticService $service)
    {
        parent::__construct();
    }

    public function handle()
    {
        $title = $this->ask('What name chanel? ["Neo", "Morpheus", "Trinity", "Cypher", "Tank"]');

        $result = $this->service->getData($title);

        $this->info('likes: ' . $this->service->likes($result));
        $this->info('dislikes: ' . $this->service->dislikes($result));

        return 0;
    }
}
