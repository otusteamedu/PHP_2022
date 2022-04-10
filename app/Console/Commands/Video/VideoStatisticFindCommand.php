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

        $results = $this->repository->search($params);

        dump($results);
        return 0;
    }

    protected function SearchCreatedDatafromQueryMatch(): void
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

        $result = $this->repository->search($params);
        dump($result);
    }

    private function getCreatedDataFromUUID(): void
    {
        $params = [
            'index' => VideoElasticsearchSearchRepository::INDEX,
            'id'    => '70d83596-618d-43a2-a231-1cdadc894944'
        ];

        $result = $this->repository->get($params);
        dump($result);
    }
}
