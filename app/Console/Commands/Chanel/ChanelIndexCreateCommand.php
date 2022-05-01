<?php


namespace App\Console\Commands\Chanel;


use App\Repositories\VideoChanelElasticsearchSearchRepository;
use Illuminate\Console\Command;

class ChanelIndexCreateCommand extends Command
{
    protected $signature = 'el:chanel:crete:index';

    protected $description = 'Generate video data for ElasticSearch';

    public function __construct(private VideoChanelElasticsearchSearchRepository $repository)
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
