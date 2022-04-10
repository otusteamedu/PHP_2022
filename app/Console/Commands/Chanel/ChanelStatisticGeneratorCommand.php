<?php


namespace App\Console\Commands\Chanel;


use App\Dtos\ChanelDto;
use App\Repositories\VideoChanelElasticsearchSearchRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ChanelStatisticGeneratorCommand extends Command
{
    protected $signature = 'el:chanel:generate';

    protected $description = 'Generate video data for ElasticSearch';

    public function __construct(private VideoChanelElasticsearchSearchRepository $repository)
    {
        parent::__construct();
    }

    public function handle()
    {
        $chanels = ["Neo", "Morpheus", "Trinity", "Cypher", "Tank"];

        $this->info('start pulling chanel data');

        foreach ($chanels as $chanel) {

            $dto = $this->createDto($chanel);
            $this->repository->save($dto);
            dump($dto);
        }

        return 0;
    }

    private function createDto(string $chanel): ChanelDto
    {
        $dto = new ChanelDto();
        $dto->id = (string) Str::uuid();
        $dto->title = $chanel;
        $dto->description = Str::random(180);

        return $dto;
    }
}
