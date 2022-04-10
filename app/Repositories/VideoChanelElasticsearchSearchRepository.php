<?php

namespace App\Repositories;

use App\Dtos\ChanelDto;
use Elasticsearch\Client;

class VideoChanelElasticsearchSearchRepository
{
    public const INDEX = 'video_chanel';

    private Client $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function get(array $params): array
    {
        return $this->elasticsearch->get($params);
    }

    public function search(array $params): array
    {
        return $this->elasticsearch->search($params);
    }

    public function save(ChanelDto $dto): void
    {
        $this->elasticsearch->index(
            array_merge($this->generateElasticSearchParams($dto->id), [
                'body' => $this->toSearchArray($dto),
            ]));
    }

    public function delete(string $id): void
    {
        $this->elasticsearch->delete(
            $this->generateElasticSearchParams($id)
        );
    }

    public function createIndex(): array
    {
        $params = [
            'index' => self::INDEX,
            'body'  => [
                'settings' => [
                    'number_of_shards' => 3,
                    'number_of_replicas' => 2
                ],
                'mappings' => [
                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => [
                        'chanel_title' => [
                            'type' => 'keyword'
                        ],
                        'description' => [
                            'type' => 'text'
                        ]
                    ]
                ],
            ]
        ];

        return $this->elasticsearch->indices()->create($params);
    }

    private function generateElasticSearchParams(string $id): array
    {
        return [
            'index' => self::INDEX,
            'id' => $id,
        ];
    }

    private function toSearchArray(ChanelDto $dto): array
    {
        return [
            'chanel_title' => $dto->title,
            'description' => $dto->description,
        ];
    }
}
