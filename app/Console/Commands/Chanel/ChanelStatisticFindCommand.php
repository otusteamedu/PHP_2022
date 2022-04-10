<?php


namespace App\Console\Commands\Chanel;


use App\Repositories\VideoChanelElasticsearchSearchRepository;
use Illuminate\Console\Command;

class ChanelStatisticFindCommand extends Command
{
    protected $signature = 'el:chanel:find';

    protected $description = 'Generate chanel for ElasticSearch';

    public function __construct(private VideoChanelElasticsearchSearchRepository $repository)
    {
        parent::__construct();
    }

    public function handle()
    {
        $title = $this->ask('What is title?');

        $params = [
            'index' => $this->repository::INDEX,
            'body'  => [
                'query' => [
                    'match' => [
                        'title' => $title,
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
            'index' => $this->repository::INDEX,
            'body'  => [
                'query' => [
                    'match' => [
                        'title' => 'Cy5vR87PXNVAorBA8gnZmlB64HMUtdjP8GNY5R5q7stoAgE0EDwb1M5uU3tpLa8ExPhZmBEjIwatUq6XgdfjPZGYHlF3v90y3VTKBuaT8EFshf9jzdLW8NaGD0lSzAllnG1RgkQpaKE4cd5d7Ok68yhgylIxqAhjbECFSxXRrWEvK2aAY9lN'
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
            'index' => $this->repository::INDEX,
            'id'    => '70d83596-618d-43a2-a231-1cdadc894944'
        ];

        $result = $this->repository->get($params);
        dump($result);
    }
}
