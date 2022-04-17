<?php


namespace App\Console\Commands\Video;


use App\Repositories\VideoElasticsearchSearchRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Dtos\VideoDto;

class VideoStatisticGeneratorCommand extends Command
{
    protected $signature = 'el:video:generate';

    protected $description = 'Generate video data for ElasticSearch';

    public function __construct(private VideoElasticsearchSearchRepository $repository)
    {
        parent::__construct();
    }

    public function handle()
    {
        $limit = 100;

        $this->info('start pulling video statistics');

        for ($i = 0; $i < $limit; $i++) {
            $dto = $this->createDto();
            $this->repository->save($dto);
            $this->info($dto);
        }

        $this->info('success');
    }

    private function createDto(): VideoDto
    {
        $chanel = ["Neo", "Morpheus", "Trinity", "Cypher", "Tank"];

        $dto = new VideoDto();
        $dto->id = (string) Str::uuid();
        $dto->videoChanel = $chanel[array_rand($chanel, 1)];
        $dto->videoTitle =  Str::random(random_int(20,255));
        $dto->description = Str::random(random_int(20,255));
        $dto->videoSeconds = random_int(0, 600);
        $dto->like = random_int(0, 999999);
        $dto->dislike = random_int(0, 999999);

        return $dto;
    }
}
