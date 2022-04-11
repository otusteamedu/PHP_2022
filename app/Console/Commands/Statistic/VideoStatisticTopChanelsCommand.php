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
        $count = (int)$this->ask('What count for top channels? - max 5 because channels:  ["Neo", "Morpheus", "Trinity", "Cypher", "Tank"]');

        $this->info("You select {$count} count of top channels");

        $params = [
            'index' => VideoElasticsearchSearchRepository::INDEX,
            'size' => 1000,
        ];

        $result = $this->repository->search($params);
        $likes = $this->sumLikes($result);
        $dislikes = $this->sumDislikes($result);

        dump('sum likes: ', $this->range($likes, $count));
        dump('sum dislikes: ', $this->range($dislikes, $count));

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

    private function sumDislikes(array $result): array
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

            $sum += $video['_source']['dislike'];

            $chanels[$chanel] = $sum;
        }

        return $chanels;
    }

    private function range(array $data, int $count): array
    {
        arsort($data);

        $i = 1;

        foreach ($data as $key => $chanel) {
            if ($i > $count) {
                unset($data[$key]);
            }

            $i++;
        }

        return $data;
    }
}
