<?php


namespace App\Console\Commands\Video;


use App\Repositories\VideoElasticsearchSearchRepository;
use Illuminate\Console\Command;

class VideoStatisticFindCommand extends Command
{
    protected $signature = 'el:video:find';

    protected $description = 'Generate video data for ElasticSearch';

    public function __construct(private VideoElasticsearchSearchRepository $repository)
    {
        parent::__construct();
    }

    public function handle()
    {
        $title = $this->ask('What is title?');

        $params = [
            'index' => VideoElasticsearchSearchRepository::INDEX,
            'body'  => [
                'query' => [
                    'match' => [
                        'video_title' => $title,
                    ]
                ]
            ]
        ];

        $result = $this->repository->search($params);
        $this->info($result);

        return $result;
    }

    protected function SearchCreatedDatafromQueryMatch(): array
    {
        $params = [
            'index' => VideoElasticsearchSearchRepository::INDEX,
            'body'  => [
                'query' => [
                    'match' => [
                        'video_title' => 'Cy5vR87PXNVAorBA8gnZmlB64HMUtdjP8GNY5R5q7stoAgE0EDwb1M5uU3tpLa8ExPhZmBEjIwatUq6XgdfjPZGYHlF3v90y3VTKBuaT8EFshf9jzdLW8NaGD0lSzAllnG1RgkQpaKE4cd5d7Ok68yhgylIxqAhjbECFSxXRrWEvK2aAY9lN'
                    ]
                ]
            ]
        ];

        return $this->repository->search($params);
    }

    private function getCreatedDataFromUUID(): array
    {
        $id = $this->ask('What is id?');

        $params = [
            'index' => VideoElasticsearchSearchRepository::INDEX,
            'id'    => $id,
        ];

        return $this->repository->get($params);
    }
}
