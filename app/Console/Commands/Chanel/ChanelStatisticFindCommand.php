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

        return $this->repository->search($params);
    }

    protected function SearchCreatedDatafromQueryMatch(): array
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

        return $this->repository->search($params);
    }

    private function getCreatedDataFromUUID(): array
    {
        $id = $this->ask('What is id?');

        $params = [
            'index' => $this->repository::INDEX,
            'id'    => $id,
        ];

        $result = $this->repository->get($params);
        $this->info($result);

        return $result;
    }
}
