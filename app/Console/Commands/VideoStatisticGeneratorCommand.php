<?php

namespace App\Console\Commands;

use ElasticsearchSearchRepository;
use Faker\Provider\zh_TW\Text;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use VideoDto;

class videoStatisticGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'el:video:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate video data for ElasticSearch';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private ElasticsearchSearchRepository $repository)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dto = new VideoDto();
        $this->repository->save($dto);

        return 0;
    }

    private function createDto(): VideoDto
    {
        $faker = new Text();

        $dto = new VideoDto();
        $dto->id = (string) Str::uuid();
        $dto->videoTitle = $faker->realText(180);
        $dto->description = $faker->realText(180);
        $dto->videoSeconds = random_int(0, 600);
        $dto->like = random_int(0, 999999);
        $dto->dislike = random_int(0, 999999);

        return $dto;
    }
}
