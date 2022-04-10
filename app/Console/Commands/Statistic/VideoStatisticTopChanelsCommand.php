<?php


namespace App\Console\Commands\Statistic;


use App\Repositories\VideoElasticsearchSearchRepository;
use Illuminate\Console\Command;

class VideoStatisticTopChanelsCommand extends Command
{
    protected $signature = 'el:video:top';

    protected $description = 'Get statistic for top chanel by likes and dislikes';

    public function __construct(private VideoElasticsearchSearchRepository $repository)
    {
        parent::__construct();
    }

    public function handle()
    {
//        $count = $this->ask('What count for top chanels? - max 5 because chanels:  ["Neo", "Morpheus", "Trinity", "Cypher", "Tank"]');
        $count = 2;

        $params = [
            'index' => VideoElasticsearchSearchRepository::INDEX,
            'size' => 1000,
        ];

        $result = $this->repository->search($params);

        dump('sum likes: ', $this->sumLikes($result));
//        dump('dislikes: ' . $this->dislikes($result));

        return 0;
    }

    private function sumLikes(array $result): array
    {
        $chanels = [];

        foreach ($result['hits']['hits'] as $video) {
            $chanel = $video['_source']['video_chanel'] ?? null;

            if ($chanel === null) {
                continue;
            }

            if (isset($chanels[$chanel])) {
                $sum = $chanels[$chanel];
            } else {
                $sum = 0;
            }

            $sum += $video['_source']['like'];

            $chanels[$chanel] = $sum;
        }

        return $chanels;
    }

    private function dislikes(array $result): int
    {
        $sum = 0;

        foreach ($result['hits']['hits'] as $video) {
            $sum += $video['_source']['dislike'];
        }

        return $sum;
    }
}
