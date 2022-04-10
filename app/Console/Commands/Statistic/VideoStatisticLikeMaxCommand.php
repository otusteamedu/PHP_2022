<?php


namespace App\Console\Commands\Statistic;


use App\Repositories\VideoElasticsearchSearchRepository;
use Illuminate\Console\Command;

class VideoStatisticLikeMaxCommand extends Command
{
    protected $signature = 'el:video:max';

    protected $description = 'Get statistic for max likes and dislikes on chanel';

    public function __construct(private VideoElasticsearchSearchRepository $repository)
    {
        parent::__construct();
    }

    public function handle()
    {
        $title = $this->ask('What name chanel? ["Neo", "Morpheus", "Trinity", "Cypher", "Tank"]');

        $params = [
            'index' => VideoElasticsearchSearchRepository::INDEX,
            'body'  => [
                'query' => [
                    'match' => [
                        'video_chanel' => $title,
                    ]
                ]
            ]
        ];

        $result = $this->repository->search($params);

        dump('likes: ' . $this->likes($result));
        dump('dislikes: ' . $this->dislikes($result));

        return 0;
    }

    private function likes(array $result): int
    {
        $sum = 0;

        foreach ($result['hits']['hits'] as $video) {
            $sum += $video['_source']['like'];
        }

        return $sum;
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
