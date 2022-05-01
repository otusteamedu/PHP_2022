<?php


namespace App\Console\Commands\Video;


use App\Repositories\VideoElasticsearchSearchRepository;
use Illuminate\Console\Command;

class VideoIndexCreateCommand extends Command
{
    protected $signature = 'el:video:crete:index';

    protected $description = 'Generate video data for ElasticSearch';

    public function __construct(private VideoElasticsearchSearchRepository $repository)
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Make index for chanel video');

        $result = $this->repository->createIndex();

        $this->info($result);

        return $result;
    }
}
